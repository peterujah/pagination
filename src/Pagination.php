<?php 
/**
 * Pagination - Light, simple  PHP and mysql Hierarchy data and organization chart
 * This class was heavily inspired by interview question
 * @author      Peter Chigozie(NG) peterujah
 * @copyright   Copyright (c), 2019 Peter(NG) peterujah
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

    private $addClass = "";

    private $allowCss = true;
    private $css = "<style>
    ul.pagination {
        display: -ms-flexbox;
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: .25rem;
        margin-top: 0;
        margin-bottom: 1rem;
    }

    .page-link {
        padding: .5rem .75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-top-right-radius: .3rem;
        border-bottom-right-radius: .3rem;
    }

    li .page-link {
        position: relative;
        display: block;
    }

    a.page-link {
        display: inline-block;
    }

    .page-link.active,
    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    </style>";

	/**
     * Constructor.
     * @param int  $total total number of records
     * @param int $type type of pagination button to display
     */
	public function __construct($total = 0, $type = self::LIST){
		$this->totalRecord = $total;
        $this->buildType = $type;
	}

    public function setLimit($limit){
        $this->pageLimit = $limit;
        return $this;
    }

    public function setCurrentPage($page = 1){
        $this->currentPage = $page;
        return $this;
    }

    public function setAllowCss($allow = true){
        $this->allowCss = $allow;
        return $this;
    }

    public function setClass($class = ""){
        $this->addClass = $class;
        return $this;
    }

    public function setTruncate($at = 4){
        $this->pageTruncate = $at;
        return $this;
    }

    public function size(){
        return $this->totalPages;
    }

    public function offset(){
        return ($this->currentPage - 1) * $this->pageLimit;
    }

    private function buttons($key, $value, $active = null){
        if(self::LIST == $this->buildType){
            return '<li class="page-item '. $active .' ' . $this->addClass . '"><a class="page-link" href="'.$key.'">'.$value.'</a></li>';
        }else if(self::LINK == $this->buildType){
            return '<a class="page-link '. $active .' ' . $this->addClass . '" href="'.$key.'">'.$value.'</a>';
        }
        return "";
    }

    public function build(){
        $build = "";
		if($this->totalRecord > 0){
			$this->totalPages = ceil($this->totalRecord / $this->pageLimit);
				if($this->currentPage > 1){ 
					$build .= $this->buttons("?n=1", "««");
					$build .= $this->buttons("?n=".($this->currentPage - 1), "«");
				}
				if ($this->currentPage > $this->pageTruncate + 1){
					$build .= $this->buttons("javascript:void(0)", "...", "disabled");
				}
				for ($i = $this->currentPage - $this->pageTruncate; $i <= $this->currentPage + $this->pageTruncate; $i++){
					if ($i >= 1 && $i <= $this->totalPages){
						if($i == $this->currentPage){
							$build .= $this->buttons("javascript:void(0)", $i, "active");
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

    public function get(){
        if(self::LIST == $this->buildType){
            return '<ul class="pagination">' . $this->build() . '</ul>';
        }else if(self::LINK == $this->buildType){
            return $this->build();
        }
        return "";
	}

    public function show(){
        if($this->allowCss){
            echo $this->css;
        }
        echo $this->get();
	}
}
