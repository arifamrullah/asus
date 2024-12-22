<?php
/**
 *	Editor properties group.
 *
 *	$group	An associative array with the data associated to this group. Each group contains: 
 *				__title		Contains the tile of the group. This shouldn't be treated as an element.
 *				__stats		[Optional] The state of the group. This is to know if the group is open.
 *				__content	[Optional] The content to use instead of the elements.
 */
 
?>

<table class="ss-group-attributes">
	<?php if (isset($group['__content'])) : ?>
		<tr>
			<td>
				<?php echo $group['__content']; ?>
			</td>
		</tr>
	<?php else: ?>
        <tr>
			<td><?php echo $group['ss-skin']; ?></td>
            <td><?php echo $group['ss-skin-filters']; ?></td>
		</tr>
        <tr>
			<td><?php echo $group['ss-skin-lightbox']; ?></td>
            <td><?php echo $group['ss-transition']; ?></td>
		</tr>
        <tr>
            <td><?php echo $group['ss-gutter']; ?></td>
			<td><?php echo $group['ss-share']; ?></td>
		</tr>
        <tr>
            <td><?php echo $group['ss-items-per-page']; ?></td>
			<td><?php echo $group['ss-pagination-type']; ?></td>
		</tr>
        <tr>
            <td><?php echo $group['ss-text-limit-type']; ?></td>
			<td><?php echo $group['ss-text-limit']; ?></td>
		</tr>
        <tr>
			<td colspan="2"><?php echo $group['ss-items-shadow']; ?></td>
		</tr>
        <tr>
			<td colspan="2"><?php echo $group['ss-filters']; ?></td>
		</tr>
        <tr>
			<td colspan="2"><?php echo $group['ss-lightbox']; ?></td>
		</tr>
        <tr>
			<td colspan="2"><?php echo $group['ss-responsive']; ?></td>
		</tr>
        <tr>
			<td colspan="2"><?php echo $group['ss-clickable-links']; ?></td>
		</tr>
        <tr>
			<td colspan="2"><?php echo $group['ss-hideifnoimage']; ?></td>
		</tr>
        <tr>
			<td colspan="2"><?php echo $group['ss-disable-for-small-screen']; ?></td>
		</tr>
	<?php endif; ?>
</table>