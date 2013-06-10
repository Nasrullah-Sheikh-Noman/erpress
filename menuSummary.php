<?php

class MenuSummary extends WPF2MenuHandler {

	public function renderPage() {
		$this->renderTitle('Summary', null, array('Add track' => array('link' => 'add-track.php', 'class' => 'add-new-h2')));
?>
<ul class="subsubsub">
	<li class="all"><a href="users.php" class="current">All <span class="count">(2)</span></a> |</li>
	<li class="administrator"><a href="users.php?role=administrator">Administrator <span class="count">(1)</span></a> |</li>
	<li class="subscriber"><a href="users.php?role=subscriber">Subscriber <span class="count">(1)</span></a></li>
</ul>
<form action="" method="get">

<p class="search-box">
	<label class="screen-reader-text" for="user-search-input">Search Users:</label>
	<input type="search" id="user-search-input" name="s" value="">
	<input type="submit" name="" id="search-submit" class="button" value="Search Users"></p>

<input type="hidden" id="_wpnonce" name="_wpnonce" value="4c31e2b95f"><input type="hidden" name="_wp_http_referer" value="/er/wp-admin/users.php">	<div class="tablenav top">

		<div class="alignleft actions">
			<select name="action">
<option value="-1" selected="selected">Bulk Actions</option>
	<option value="delete">Delete</option>
</select>
<input type="submit" name="" id="doaction" class="button action" value="Apply">
		</div>
	<div class="alignleft actions">
				<label class="screen-reader-text" for="new_role">Change role to…</label>
		<select name="new_role" id="new_role">
			<option value="">Change role to…</option>
			
	<option value="administrator">Administrator</option>
	<option value="editor">Editor</option>
	<option value="author">Author</option>
	<option value="contributor">Contributor</option>
	<option value="subscriber">Subscriber</option>		</select>
	<input type="submit" name="changeit" id="changeit" class="button" value="Change"></div><div class="tablenav-pages one-page"><span class="displaying-num">2 items</span>
<span class="pagination-links"><a class="first-page disabled" title="Go to the first page" href="http://localhost/er/wp-admin/users.php">«</a>
<a class="prev-page disabled" title="Go to the previous page" href="http://localhost/er/wp-admin/users.php?paged=1">‹</a>
<span class="paging-input"><input class="current-page" title="Current page" type="text" name="paged" value="1" size="1"> of <span class="total-pages">1</span></span>
<a class="next-page disabled" title="Go to the next page" href="http://localhost/er/wp-admin/users.php?paged=1">›</a>
<a class="last-page disabled" title="Go to the last page" href="http://localhost/er/wp-admin/users.php?paged=1">»</a></span></div>
		<br class="clear">
	</div>
<table class="wp-list-table widefat fixed users" cellspacing="0">
	<thead>
	<tr>
		<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></th><th scope="col" id="username" class="manage-column column-username sortable desc" style=""><a href="http://localhost/er/wp-admin/users.php?orderby=login&amp;order=asc"><span>Username</span><span class="sorting-indicator"></span></a></th><th scope="col" id="name" class="manage-column column-name sortable desc" style=""><a href="http://localhost/er/wp-admin/users.php?orderby=name&amp;order=asc"><span>Name</span><span class="sorting-indicator"></span></a></th><th scope="col" id="email" class="manage-column column-email sortable desc" style=""><a href="http://localhost/er/wp-admin/users.php?orderby=email&amp;order=asc"><span>E-mail</span><span class="sorting-indicator"></span></a></th><th scope="col" id="role" class="manage-column column-role" style="">Role</th><th scope="col" id="posts" class="manage-column column-posts num" style="">Posts</th>	</tr>
	</thead>

	<tfoot>
	<tr>
		<th scope="col" class="manage-column column-cb check-column" style=""><label class="screen-reader-text" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox"></th><th scope="col" class="manage-column column-username sortable desc" style=""><a href="http://localhost/er/wp-admin/users.php?orderby=login&amp;order=asc"><span>Username</span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-name sortable desc" style=""><a href="http://localhost/er/wp-admin/users.php?orderby=name&amp;order=asc"><span>Name</span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-email sortable desc" style=""><a href="http://localhost/er/wp-admin/users.php?orderby=email&amp;order=asc"><span>E-mail</span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-role" style="">Role</th><th scope="col" class="manage-column column-posts num" style="">Posts</th>	</tr>
	</tfoot>

	<tbody id="the-list" data-wp-lists="list:user">
		
	<tr id="user-2" class="alternate"><th scope="row" class="check-column"><label class="screen-reader-text" for="cb-select-2">Select sandrine</label><input type="checkbox" name="users[]" id="user_2" class="subscriber" value="2"></th><td class="username column-username"> <strong><a href="http://localhost/er/wp-admin/user-edit.php?user_id=2&amp;wp_http_referer=%2Fer%2Fwp-admin%2Fusers.php">sandrine</a></strong><br><div class="row-actions"><span class="edit"><a href="http://localhost/er/wp-admin/user-edit.php?user_id=2&amp;wp_http_referer=%2Fer%2Fwp-admin%2Fusers.php">Edit</a> | </span><span class="delete"><a class="submitdelete" href="users.php?action=delete&amp;user=2&amp;_wpnonce=4c31e2b95f">Delete</a></span></div></td><td class="name column-name">Sandrine Kohler</td><td class="email column-email"><a href="mailto:sandrine@skym.fr" title="E-mail: sandrine@skym.fr">sandrine@skym.fr</a></td><td class="role column-role">Subscriber</td><td class="posts column-posts num">0</td></tr>
	<tr id="user-1"><th scope="row" class="check-column"><label class="screen-reader-text" for="cb-select-1">Select yannick</label><input type="checkbox" name="users[]" id="user_1" class="administrator" value="1"></th><td class="username column-username"> <strong><a href="http://localhost/er/wp-admin/profile.php?wp_http_referer=%2Fer%2Fwp-admin%2Fusers.php">yannick</a></strong><br><div class="row-actions"><span class="edit"><a href="http://localhost/er/wp-admin/profile.php?wp_http_referer=%2Fer%2Fwp-admin%2Fusers.php">Edit</a></span></div></td><td class="name column-name">Yannick Mauray</td><td class="email column-email"><a href="mailto:yannick.mauray@euterpia-radio.fr" title="E-mail: yannick.mauray@euterpia-radio.fr">yannick.mauray@euterpia-radio.fr</a></td><td class="role column-role">Administrator</td><td class="posts column-posts num"><a href="edit.php?author=1" title="View posts by this author" class="edit">147</a></td></tr>	</tbody>
</table>
	<div class="tablenav bottom">

		<div class="alignleft actions">
			<select name="action2">
<option value="-1" selected="selected">Bulk Actions</option>
	<option value="delete">Delete</option>
</select>
<input type="submit" name="" id="doaction2" class="button action" value="Apply">
		</div>
<div class="tablenav-pages one-page"><span class="displaying-num">2 items</span>
<span class="pagination-links"><a class="first-page disabled" title="Go to the first page" href="http://localhost/er/wp-admin/users.php">«</a>
<a class="prev-page disabled" title="Go to the previous page" href="http://localhost/er/wp-admin/users.php?paged=1">‹</a>
<span class="paging-input">1 of <span class="total-pages">1</span></span>
<a class="next-page disabled" title="Go to the next page" href="http://localhost/er/wp-admin/users.php?paged=1">›</a>
<a class="last-page disabled" title="Go to the last page" href="http://localhost/er/wp-admin/users.php?paged=1">»</a></span></div>
		<br class="clear">
	</div>
</form>
<?php
	}
}

?>
