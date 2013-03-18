<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
<div>
<input type="hidden" id="searchsubmit" value="Search" />
<input type="text" class="search_input" value="Search & Hit Enter" name="s" id="s" onfocus="if (this.value == 'Search & Hit Enter') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search & Hit Enter';}" />

<input type="submit" id="searchsubmit" value="Go" class="search_button" />
</div>
</form>
