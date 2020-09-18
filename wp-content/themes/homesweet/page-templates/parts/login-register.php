
<div class="login-register-hidden hidden">
	<div class="login-register">
		<ul class="nav nav-tabs">
			<li id="customer_login" class="active"><a data-toggle="tab" href="#login-register-login"><?php esc_html_e('Login', 'homesweet'); ?></a></li>
			<?php if ( get_option( 'users_can_register' ) ) : ?>
				<li id="customer_register"><a data-toggle="tab" href="#login-register-register"><?php esc_html_e('Register', 'homesweet'); ?></a></li>
			<?php endif; ?>
		</ul>
		<div class="tab-content">
		  	<div id="login-register-login" class="tab-pane fade in active">
		  		<?php echo Realia_Template_Loader::load('misc/login'); ?>
		  	</div>
		  	<?php if ( get_option( 'users_can_register' ) ) : ?>
			  	<div id="login-register-register" class="tab-pane fade in">
			  		<?php echo Realia_Template_Loader::load('misc/register'); ?>
			  	</div>
		  	<?php endif; ?>
		</div>
	</div>
</div>