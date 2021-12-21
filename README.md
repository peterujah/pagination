# PHP Pagination 

Pagination is a simple pagging in php


## Installation

Installation is super-easy via Composer:
```md
composer require peterujah/pagination
```

# USAGES

Hierarchical can be use as an array, html or google organizations chart

```php 
 use Peterujah\NanoBlock\Pagination;
 $paging = new Pagination($rowCount, Pagination::LIST);
 $paging = new Pagination($rowCount, Pagination::LINK);
```
  
Dump array 
  
```php 
 $paging = new Pagination(100, Pagination::LIST);
 $paging->setLimit(20);
 $paging->setCurrentPage($_GET["page"]??1)->show();
 ```
   
```php 
 $paging = new Pagination(100, Pagination::LIST);
 $paging->setLimit(20);
 $html = $paging->setCurrentPage($_GET["page"]??1)->get();
```

Use built in css style, only work with `$paging->show()` method

``` php 
$paging->setAllowCss(true);
```

Initalisation options `new Pagination($rowCount, Pagination::LINK)`

| Options         | Description                                                                         |
|-----------------|-------------------------------------------------------------------------------------|
| LIST            | Retrieve result as an html list                                                     |
| LINK            | Retrieve result in HTML link                                                        |

