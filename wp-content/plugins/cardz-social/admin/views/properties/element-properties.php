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
			<td><?php echo $group['ss-el-width']; ?></td>
            <td><?php echo $group['ss-el-height']; ?></td>
		</tr>
        <tr>
            <td colspan="2"><?php echo $group['ss-el-position']; ?></td>
        </tr>
        <tr>
            <td colspan="2"><?php echo $group['ss-el-margins']; ?></td>
        </tr>
        <tr>
            <td colspan="2"><?php echo $group['ss-el-paddings']; ?></td>
        </tr>
        <tr>
			<td><?php echo $group['ss-font-family']; ?></td>
            <td><?php echo $group['ss-font-size']; ?></td>
		</tr>
        <tr>
            <td><?php echo $group['ss-font-color']; ?></td>
			<td><?php echo $group['ss-background']; ?></td>
		</tr>
        <tr>
            <td colspan="2"><?php echo $group['ss-text-align']; ?></td>
        </tr>
        <tr>
			<td colspan="2"><?php echo $group['ss-border-width']; ?></td>
		</tr>
        <tr>
            <td><?php echo $group['ss-border-color']; ?></td>
            <td><?php echo $group['ss-border-style']; ?></td>
        </tr>
        <tr><td><?php echo $group['ss-css-data']; ?></td></tr>
	<?php endif; ?>
</table>