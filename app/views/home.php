<?php
use Carbon\Carbon;

if (Session::has('flash_error'))
{
	?>
	<div id="flash_error" class="alert alert-danger"><?=Session::get('flash_error')?></div>
	<?php
}

if (Session::has('flash_msg'))
{
	?>
	<div id="flash_error" class="alert alert-info"><?=Session::get('flash_msg')?></div>
	<?php
}
?>

<?php
if($activeTimers->count() > 0)
{
	foreach($activeTimers as $timer)
	{
		if(strtotime($timer->timeExiting) > time())
		{
			?>
			<div id="flash_error" class="alert alert-success">Next Timer: <strong data-livestamp="<?=Carbon::createFromTimeStamp(strtotime($timer->timeExiting))->toISO8601String()?>"><?=Carbon::createFromTimeStamp(strtotime($timer->timeExiting))->diffForHumans();?></strong></div>
			<?php
			break;
		}
	}
}
?>

<div class="row">
	<div class="col-lg-12">
		<h3>
			<?php
			if(Auth::user()->permission === '1')
			{
				?>
				<a href="<?=URL::to('add')?>" class="btn btn-success pull-right btn-sm">New</a>
				<?php
			}
			?>
			Active Timers <label class="label label-default now time-now"><?=date('Y-m-d H:i:s e', time())?></label>
		</h3>
		<div>
			<?php
			/*
			 * Load the timer content here
			 */
			echo $timer_table_new;
			?>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<h3>
			Expired Timers
		</h3>
		<div>
			<?php
			/*
			 * Load the timer content here
			 */
			echo $timer_table_old;
			?>
		</div>
	</div>
</div>
