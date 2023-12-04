# PHP Pagination 

Pagination is a simple package that can generate HTML to navigate between listing pages.

It takes as parameter values the type of navigation to generate and the total number of entries in the listing.

The class generates HTML with links to allow the user to click and go to the other listing pages considering the current listing page number.

The class's navigation can be either a list of links or just a group of links pointing to each listing page.

Developers can configure the presentation of the navigation using custom CSS styles or bootstrap pagination.


## Installation

Installation is super-easy via Composer:
```md
composer require peterujah/pagination
```

# USAGES

Pagination can be used as an HTML hyperlink or HTML unordered list

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

Use built-in css style, only work with `$paging->show()` method

``` php 
$paging->setAllowCss(true);
```

## Constants
Initalisation options `new Pagination($rowCount, Pagination::LINK)`

| Options         | Description                                                                         |
|-----------------|-------------------------------------------------------------------------------------|
| LIST            | Retrieve result as an html unordered list                                           |
| LINK            | Retrieve result in HTML hyperlink                                                   |

## Methods

| Method                    | Description                                                                         |
|---------------------------|-------------------------------------------------------------------------------------|
| setLimit(int)             | Set query row display limit per page                                                |
| setCurrentPage(int)       | Set current paging number                                                           |
| addQuery(string, string)  | Add query parameter (key, value)                                                    |
| setQueries(array)         | Set query parameters array(key => value)                                            |
| setAllowCss(bool)         | Enable default paging buttons styling                                               |
| setClass(string)          | Set a custom class name for paging list items `li`                                  |
| setParentClass(string)    | Set a custom class name for pagination unordered list `ul`                          |
| setTruncate(int)          | Set pagination truncate offset                                                      |
| getSize() :int            | Get total pagination calculated cell pages                                          |
| getOffset() :int          | Get pagination next page start offset                                               |
| get() :HTML:false         | Returns pagination generated html                                                   |
| show() :void              | Display pagination buttons                                                          |



## Full usage example

Example: Specify the total number of rows in your table `findTotalUsers :(int)`, then select only the number of items to show per page `findUsers(startOffset, limitPerPage)`

```php
use Peterujah\NanoBlock\Pagination;
// Configure page limit
$queryLimit = 30;
$queryPage = $_GET["n"]??1;
$queryStart = ($queryPage - 1) * $queryLimit;

// Query your database table
$users = (object) array(
    "users" => $conn->findUsers($queryStart, $queryLimit),
    "rowCount" => $conn->findTotalUsers()
);

// Initialize Pagination
$paging = new Pagination($users->rowCount, Pagination::LIST);
$paging->setLimit($queryLimit);
$paging->setCurrentPage($queryPage);

// Display your contents
foreach($users->users as $row){
    echo "<div>{$row->userFullname}</div>";
}
// Add pagination buttons
echo "<nav aria-label='Page navigation'>";
echo $paging->get();
echo "</nav>";
```
