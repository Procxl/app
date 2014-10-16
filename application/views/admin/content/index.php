<div class='container content'>
    <div class='row'>
       <div class="span4">
            <div class="row-fluid">
                <?php echo Modules::run('samples/top_samples', 3); ?>
            </div>
       </div>
       <div class="span4">
            <div class="row-fluid">
                <?php echo Modules::run('inquiries/top_inquiries', 3); ?>
            </div>
       </div>
	</div>
    <div class='row-fluid'>
        <div class='span12'>
            <div class='row-fluid'>
                <?php echo Modules::run('containers/top_containers', 5); ?>
            </div>
       </div>
    </div>
</div>