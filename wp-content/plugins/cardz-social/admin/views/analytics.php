<?php
/**
 *	Analytics panel.
 *
 *	Available variables:
 *		$post_id		The ID of the post being analised.
 */
?>
<div class="ss-analytics-wrapper">
	<?php if (!empty($post_id)) : ?>
		<div class="ss-analytics-toolbar">
			<div class="ss-analytics-data ss-select-element">
				<span class="text"><?php _e('All', 'cardz-social'); ?></span>
				<div class="ss-select-submenu">
					<ul>
                        <li data-name="all" class="selected"><?php _e('All', 'cardz-social'); ?></li>
						<li data-name="views"><?php _e('Views', 'cardz-social'); ?></li>
						<li data-name="clicks"><?php _e('Clicks', 'cardz-social'); ?></li>
						<li data-name="conversions"><?php _e('Conversions', 'cardz-social'); ?></li>
						<li data-name="conversion_rate"><?php _e('Conversion Rate', 'cardz-social'); ?></li>
						<li data-name="time_on_popup"><?php _e('Time on stream', 'cardz-social'); ?></li>
						<li data-name="time_on_page"><?php _e('Time on page', 'cardz-social'); ?></li>
					</ul>
				</div>
			</div>
			
			<p>for</p>
			
			<div class="ss-analytics-date-range ss-date-range-element">
				<span class="text">November 1, 2014 - November 30, 2014</span>
				<div class="ss-date-submenu">
					<ul class="ranges">
						<li data-name="today"><?php _e('Today', 'cardz-social'); ?></li>
						<li data-name="yesterday"><?php _e('Yesterday', 'cardz-social'); ?></li>
						<li data-name="last_7_days"><?php _e('Last 7 Days', 'cardz-social'); ?></li>
						<li data-name="last_30_days"><?php _e('Last 30 Days', 'cardz-social'); ?></li>
						<li data-name="this_month" class="selected"><?php _e('This Month', 'cardz-social'); ?></li>
						<li data-name="last_month"><?php _e('Last Month', 'cardz-social'); ?></li>
						<li data-name="custom_range"><?php _e('Custom Range', 'cardz-social'); ?></li>
					</ul>
					<div class="range-edits">
						<input type="text" class="from-date" readonly="true" />
						<input type="text" class="to-date" readonly="true" />
						<div class="ss-calendar"></div>
					</div>
				</div>
			</div>
			
		</div>
		<div class="ss-statistics">
            <canvas id="ss-main-chart" width="900" height="200" style="width: 900px; height: 200px;"></canvas>
            <div class="ss-inline-chart">
                <div class="ss-chart-col">
                    <canvas id="ss-views-chart" width="100" height="100" style="width: 100px; height: 100px;"></canvas>
                    <div class="ss-info">
                        <span class="ss-info-value">0</span>
                        <span class="ss-info-title"><?php _e('Views', 'cardz-social'); ?></span>
                    </div>
                </div>
                <div class="ss-chart-col">
                    <canvas id="ss-clicks-chart" width="100" height="100" style="width: 100px; height: 100px"></canvas>
                    <div class="ss-info">
                        <span class="ss-info-value">0</span>
                        <span class="ss-info-title"><?php _e('Clicks', 'cardz-social'); ?></span>
                    </div>
                </div>
                <div class="ss-chart-col">
                    <canvas id="ss-conversions-chart" width="100" height="100" style="width: 100px; height: 100px"></canvas>
                    <div class="ss-info">
                        <span class="ss-info-value">0</span>
                        <span class="ss-info-title"><?php _e('Conversions', 'cardz-social'); ?></span>
                    </div>
                </div>
                <div class="ss-chart-col">
                    <canvas id="ss-conversion-rate-chart" width="100" height="100" style="width: 100px; height: 100px"></canvas>
                    <div class="ss-info">
                        <span class="ss-info-value">0%</span>
                        <span class="ss-info-title"><?php _e('Conversion Rate', 'cardz-social'); ?></span>
                    </div>
                </div>
            </div>
        </div>
		<script type="text/javascript">
			var analytics = new ss_admin.Analytics();
            
			<?php $db_data = CardZStream()->admin->analytics->get_data($post_id); ?>
			var analytics_data = <?php echo $this->format_data($db_data); ?>;
            
			analytics.init(analytics_data, <?php echo $post_id; ?>);
		</script>
	<?php else : ?>
		<h1><?php _e('Please select a stream from the stream list', 'cardz-social'); ?></h1>
	<?php endif; ?>
</div>