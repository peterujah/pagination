# PHP Pagination 

Pagination is a simple package that can generate HTML to navigate between listing pages.

It takes as parameter values the type of navigation to generate and the total number of entries in the listing.

The class generates HTML with links to allow the user to click and go to the other listing pages considering the current listing page number.

The class's navigation can be either a list of links or just a group of links pointing to each listing page.

Developers can configure the presentation of the navigation using CSS styles.


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

