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
     * @var int
     */
    	public const LIST = 1;

    /**
     * Hold html links only pagination design
     *
     * @var int
     */
	public const LINK = 3;

    /**
     * Hold pagination current page number
     * @var object
     */
	private $currentPage = 1;

    /**
     * Holds total calculated cell pages
     * @var array
     */
	private $totalPages = 0;

    /**
     * Holds truncate index position
     * @var int
     */
	private $pageTruncate = 4;
	
	/**
     * Holds total record row count
     * @var int
     */
	private $totalRecord = 0;

    /**
     * Holds record row limit count per page
     * @var int
     */
    	private $pageLimit = 20;

    /**
     * Holds pagination button to display type
     * @var int
     */
   	 private $buildType;

    /**
     * Holds addition url parameters
     * @var array
     */
   	 protected $urlQueries = array();

    /**
     * Holds additional pagination button class name
     * @var string
     */
   	 private $addClass = "";

    /**
     * Holds additional pagination ul parent class name
     * @var string
     */
   	 private $parentClass = "";

    /**
     * Holds boolean value to allow include of inline css style in page
     * @var bool
     */
    	private $allowCss = true;
	
    /**
     * Holds inline css style for buttons display
     * @var string
     */
   	 protected $css = "<style>ul.pagination{display:-ms-flexbox;display:flex;padding-left:0;list-style:none;border-radius:.25rem;margin-top:0;margin-bottom:1rem}.page-link{padding:.5rem .75rem;margin-left:-1px;line-height:1.25;color:#007bff;background-color:#fff;border:1px solid #dee2e6;border-top-right-radius:.3rem;border-bottom-right-radius:.3rem}li .page-link{position:relative;display:block}a.page-link{display:inline-block}.page-link.active,.page-item.active .page-link{z-index:3;color:#fff;background-color:#007bff;border-color:#007bff}</style>";

	/**
     * Constructor.
     * @param int  $total total number of records
     * @param int $type type of pagination button to display
     */
	public function __construct($total = 0, $type = self::LIST){
		$this->totalRecord = $total;
        $this->buildType = $type;
	}

    /**
     * Sets maximum record limit per page
     * @param int $limit row per page
     * @return $this
     */
    public function setLimit($limit){
        $this->pageLimit = $limit;
        return $this;
    }

    /**
     * Sets the current pagination page number
     * @param int $page page number
     * @return $this
     */
    public function setCurrentPage($page = 1){
        $this->currentPage = $page;
        return $this;
    }

    /**
     * Add additional url query parameter
     * @param string $key query name
     * @param mixed $value query value
     * @return $this
     */
    public function addQuery($key, $value){
        $this->urlQueries[$key] = $value;
        return $this;
    }

    /**
     * Sets additional url query parameter
     * @param string $array query name and value in arrays array(name => value, name => value 2)
     * @return $this
     */
    public function setQueries($array){
        if(is_array($array)){
            $this->urlQueries = $array;
        }
        return $this;
    }

   /**
     * Builds additional query string to add to the URL
     * @param mixed $link If the initial link value is no # add any additional items
     * @return string will return additional url query string
     */
    protected function buildQuery($link){
        if(!empty($this->urlQueries) && $link != "#"){
            return http_build_query(array_filter($this->urlQueries), '', '&amp;');
        }
        return "";
    }

    /**
     * Sets allow inline css style
     * @param bool $allow boolean value to indicate if inline css will be created
     * @return $this
     */
    public function setAllowCss($allow = true){
        $this->allowCss = $allow;
        return $this;
    }

    /**
     * Sets additional links button class name
     * @param string $class class name separate with space for multiple class names
     * @return $this
     */
    public function setClass($class = ""){
        $this->addClass = $class;
        return $this;
    }

    /**
     * Sets additional links button class name
     * @param string $class class name separate with space for multiple class names
     * @return $this
     */
    public function setParentClass($class = ""){
        $this->parentClass = $class;
        return $this;
    }

    /**
     * Sets pagination links truncate position
     * @param int $at truncate index position
     * @return $this
     */
    public function setTruncate($at = 4){
        $this->pageTruncate = $at;
        return $this;
    }

    /**
     * Get total pagination links
     * @return int
     */
    public function getSize(){
        return $this->totalPages;
    }

    /**
     * Get pagination next page start offset
     * @return int
     */
    public function getOffset(){
        return ($this->currentPage - 1) * $this->pageLimit;
    }

     /**
     * Build pagination links with the initial line, value and status
     * @param string $link Initial link url parameter
     * @param mixed $value This is the paging button text, it can set as numbers, arrows or dots etc
     * @param string $active If this is the active or disabled paging link
     * @return string This will return the paging html link as a string
     */
    protected function buttons($link, $value, $active = null){
        if(self::LIST == $this->buildType){
            return '<li class="page-item '. $active .' ' . $this->addClass . '"><a class="page-link" href="' . $link . $this->buildQuery($link) . '" title="Page ' . $value . '">'.$value.'</a></li>';
        }else if(self::LINK == $this->buildType){
            return '<a class="page-link '. $active .' ' . $this->addClass . '" href="' . $link . $this->buildQuery($link) . '" title="Page ' . $value . '">'.$value.'</a>';
        }
        return "";
    }

     /**
     * Create paging links and buttons for the number of records
     * @return string Returns the pagination buttons if available else will return empty
     */
    protected function paging(){
        $build = "";
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
     * @return string|false return paging links if available else will return false
     */
    public function get(){
        if(self::LIST == $this->buildType){
            return '<ul class="pagination ' . $this->parentClass . '">' . $this->paging() . '</ul>';
        }else if(self::LINK == $this->buildType){
            return $this->paging();
        }
        return false;
    }

    /**
     * Preview pagination menu links and buttons in page
     * @display paging links and button in page as html or html string
     */
    public function show(){
        if($this->allowCss){
            echo $this->css;
        }
        echo $this->get();
    }
}
