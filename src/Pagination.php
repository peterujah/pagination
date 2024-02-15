<?php 
/**
 * Pagination - Light, simple  PHP and mysql Hierarchy data and organization chart
 * This class was heavily inspired by interview question
 * @author      Peter Chigozie(NG) peterujah
 * @copyright   Copyright (c), 2021 Peter(NG) peterujah
 * @license     MIT public license
 */
namespace Peterujah\NanoBlock;

/**
 * Class Pagination.
 */
class Pagination {
    /**
     * Hold html under list pagination design
     *
     * @var int LIST
    */
    public const LIST = 1;

    /**
     * Hold html links only pagination design
     *
     * @var int LINK
    */
	public const LINK = 3;

    /**
     * Hold pagination current page number
     * @var int $currentPage
    */
	private int $currentPage = 1;

    /**
     * Holds total calculated cell pages
     * @var int $totalPages
     */
	private int $totalPages = 0;

    /**
     * Holds truncate index position
     * @var int $pageTruncate
    */
	private int $pageTruncate = 4;
	
	/**
     * Holds total record row count
     * @var int $totalRecord
    */
	private int $totalRecord = 0;

    /**
     * Holds record row limit count per page
     * @var int $pageLimit
    */
    private int $pageLimit = 20;

    /**
     * Holds pagination button to display type
     * @var int $buildType
    */
   	private int $buildType = 1;

    /**
     * Holds addition url parameters
     * @var array $urlQueries
    */
    private array $urlQueries = [];

    /**
     * Holds additional pagination button class name
     * @var string $addClass
    */
   	private string $addClass = '';

    /**
     * Holds additional pagination ul parent class name
     * @var string $parentClass
     */
   	 private string $parentClass = '';

    /**
     * Holds boolean value to allow include of inline css style in page
     * @var bool $allowCss
    */
    private bool $allowCss = true;
	
     /**
     * Holds boolean value to allow default item class
     * @var bool $itemClass
    */
    private bool $itemClass = true;

    /**
     * Holds inline css style for buttons display
     * @var string $css
    */
   	private string $css = "<style>ul.pagination{display:-ms-flexbox;display:flex;padding-left:0;list-style:none;border-radius:.25rem;margin-top:0;margin-bottom:1rem}.page-link{padding:.5rem .75rem;margin-left:-1px;line-height:1.25;color:#007bff;background-color:#fff;border:1px solid #dee2e6;border-top-right-radius:.3rem;border-bottom-right-radius:.3rem}li .page-link{position:relative;display:block}a.page-link{display:inline-block}.page-link.active,.page-item.active .page-link{z-index:3;color:#fff;background-color:#007bff;border-color:#007bff}</style>";

	/**
     * Constructor.
     * @param int  $total total number of records
     * @param int $type type of pagination button to display
    */
	public function __construct(int $total = 0, int $type = self::LIST)
    {
		$this->totalRecord = $total;
        $this->buildType = $type;
	}

    /**
     * Sets maximum record limit per page
     * 
     * @param int $limit row per page
     * 
     * @return $this
     */
    public function setLimit(int $limit): self 
    {
        $this->pageLimit = $limit;
        
        return $this;
    }

    /**
     * Sets the current pagination page number
     * 
     * @param int $page page number
     * 
     * @return $this
     */
    public function setCurrentPage(int $page): self 
    {
        $this->currentPage = $page;

        return $this;
    }

    /**
     * Add additional url query parameter
     * 
     * @param string $key query name
     * @param mixed $value query value
     * 
     * @return $this
     */
    public function addQuery(string $key, mixed $value): self 
    {
        $this->urlQueries[$key] = $value;

        return $this;
    }

    /**
     * Sets additional url query parameter
     * 
     * @param string $queries query name and value in arrays array(name => value, name => value 2)
     * 
     * @return $this
     */
    public function setQueries(array $queries): self 
    {
        $this->urlQueries = $queries;

        return $this;
    }

    /**
     * Sets allow inline css style
     * 
     * @param bool $allow boolean value to indicate if inline css will be created
     * 
     * @return $this
     */
    public function setAllowCss(bool $allow): self 
    {
        $this->allowCss = $allow;

        return $this;
    }

    /**
     * Sets additional links button class name
     * 
     * @param string $class class name separate with space for multiple class names
     * 
     * @return $this
     */
    public function setClass(string $class): self
    {
        $this->addClass = $class;
        return $this;
    }

     /**
     * Sets enable add default item class
     * 
     * @param bool $itemClass 
     * 
     * @return $this
     */
    public function setItemClass(bool $itemClass): self 
    {
        $this->itemClass = $itemClass;

        return $this;
    }

    /**
     * Sets additional links button class name
     * 
     * @param string $class class name separate with space for multiple class names
     * 
     * @return $this
     */
    public function setParentClass(string $class): self 
    {
        $this->parentClass = $class;
        return $this;
    }

    /**
     * Sets pagination links truncate position
     * 
     * @param int $truncate truncate index position
     * 
     * @return $this
     */
    public function setTruncate(int $truncate): self 
    {
        $this->pageTruncate = $truncate;

        return $this;
    }

    /**
     * Builds additional query string to add to the URL
     * 
     * @param mixed $link If the initial link value is not # add any additional items
     * 
     * @return string will return additional url query string
     */
    protected function buildQuery(string $link): string 
    {
        if($this->urlQueries === [] || $link === '#'){
            return '';
        }

        return http_build_query(array_filter($this->urlQueries), '', '&amp;');
    }

    /**
     * Get total pagination links
     * 
     * @return int
     */
    public function getSize(): int 
    {
        return $this->totalPages;
    }

    /**
     * Get pagination next page start offset
     * @return int
     */
    public function getOffset(): int 
    {
        return ($this->currentPage - 1) * $this->pageLimit;
    }

     /**
     * Build pagination links with the initial line, value and status
     * 
     * @param string $link Initial link url parameter
     * @param mixed $value This is the paging button text, it can set as numbers, arrows or dots etc
     * @param string $active If this is the active or disabled paging link
     * 
     * @return string This will return the paging html link as a string
     */
    private function buttons(string $link, mixed $value, ?string $active = null): string 
    {
        $class = $active .' ' . $this->addClass;
        if(self::LIST == $this->buildType){
            $class .= $this->itemClass ? ' page-item' : '';

            return '<li class="'. $class . '"><a class="page-link" href="' . $link . $this->buildQuery($link) . '" title="Page ' . $value . '">'.$value.'</a></li>';
        } 
        
        if(self::LINK == $this->buildType){
            $class .= $this->itemClass ? ' page-link' : '';

            return '<a class="' . $class . '" href="' . $link . $this->buildQuery($link) . '" title="Page ' . $value . '">'.$value.'</a>';
        }
        return '';
    }

     /**
     * Create paging links and buttons for the number of records
     * 
     * @return string Returns the pagination buttons if available else will return empty
     */
    private function createPaging(): string 
    {
        $build = '';
        if($this->totalRecord > 0){
            $this->totalPages = ceil($this->totalRecord / $this->pageLimit);
            if($this->currentPage > 1){ 
                $build .= $this->buttons("?n=1", "««");
                $build .= $this->buttons("?n=".($this->currentPage - 1), "«");
            }
            if ($this->currentPage > $this->pageTruncate + 1){
                $build .= $this->buttons("#", "...", "disabled");
            }
            for ($i = $this->currentPage - $this->pageTruncate; $i <= $this->currentPage + $this->pageTruncate; $i++){
                if ($i >= 1 && $i <= $this->totalPages){
                    if($i == $this->currentPage){
                        $build .= $this->buttons("#", $i, "active");
                    }else{
                        $build .= $this->buttons("?n=" . $i, $i);
                    }
                }
            }
            if($this->currentPage != $this->totalPages){
                $build .= $this->buttons("?n=" . ($this->currentPage + 1), "»");
                $build .= $this->buttons("?n=" . $this->totalPages, "»»");
            }
        }
        return $build;
    }

    /**
     * Return pagination menu links and buttons
     * 
     * @return string|false return paging links if available else will return false
     */
    public function get(): mixed 
    {
        if(self::LIST == $this->buildType){
            return '<ul class="pagination ' . $this->parentClass . '">' . $this->createPaging() . '</ul>';
        }

        if(self::LINK == $this->buildType){
            return $this->createPaging();
        }

        return false;
    }

    /**
     * Preview pagination menu links and buttons in page
     * echo paging links and button in page as html or html string
     * 
     * @return void 
    */
    public function show(): void 
    {
        if($this->allowCss){
            echo $this->css;
        }
        echo $this->get();
    }

    /**
     * Check if url queries has a valid key
     * 
     * @param array $queries
     * 
     * @return bool 
    */
    private function queryHasKey(array $queries): bool 
    {
        foreach ($queries as $key => $value) {
            if (is_string($key)) {
                return true; 
            }
        }
    
        return false; 
    }
}
