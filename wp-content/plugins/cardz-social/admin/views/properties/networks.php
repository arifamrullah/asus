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
			<td colspan="2"><?php echo $group['ss-networks']; ?></td>
		</tr>
        <tr>
			<td colspan="2"><?php echo $group['ss-custom-item']; ?></td>
		</tr>
        <tr>
			<td><?php echo $group['ss-order-by']; ?></td>
            <td><?php echo $group['ss-order']; ?></td>
		</tr>
        <tr>
            <td><?php echo $group['ss-items-limit']; ?></td>
            <td></td>
        </tr>
        <!--<tr>
			<td colspan="2"><?php echo $group['ss-moderate-posts']; ?></td>
		</tr>-->
	<?php endif; ?>
</table>