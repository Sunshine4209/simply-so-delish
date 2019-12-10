<?php
/**
 * The template for displaying the search form
 *
 * @package kale
 */
?>
<form role="search" style="margin: 0 0 -9px -5px;" method="get" class="search-form" action="<?php echo esc_url(home_url( '/' )); ?>">
    <div class="sunshine_search_container">
        <div class="form-group search_bar" style="float: left; padding-left: 5px;"><input style="width: 320px;padding-left: 10px;" type="search" placeholder="search for a recipe" class="search-field form-control" value="<?php echo get_search_query() ?>" name="s" /></div>
        <div style="clear: both;"></div>
    </div>
</form>
