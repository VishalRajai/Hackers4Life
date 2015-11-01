<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/front/assets/plugins/jScrollPane/jScrollPane.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/front/assets/css/chat.css" />

<div id="chatContainer" style="display:none;">

    <div id="chatTopBar" class="rounded">Support Chat</div>
    <span id="chatMain" style="display:none;">
        <div id="chatLineHolder"></div>
        <div id="chatBottomBar" class="rounded">
        	<div class="tip"></div>
            
            <form id="loginForm" method="post" action="">
                <input id="name" name="name" class="rounded" maxlength="16" />
                <input id="email" name="email" class="rounded" />
                <input type="submit" class="blueButton" value="Login" />
            </form>
            
            <form id="submitForm" method="post" action="">
                <input id="chatText" name="chatText" class="rounded" maxlength="255" />
                <input type="submit" class="blueButton" value="Submit" />
            </form>
            
        </div>
    </span>
    
</div>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/jScrollPane/jScrollPane.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#chatTopBar").click(function(){
            $("#chatMain").toggle('fast');
        });
    });
</script>
