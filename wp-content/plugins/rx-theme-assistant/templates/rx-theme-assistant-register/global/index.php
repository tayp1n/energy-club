<?php
/**
 * Register form template
 */
$username = ! empty( $_POST['username'] ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : '';
$email    = ! empty( $_POST['email'] ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : '';
?>
<form method="post" class="rx-register">

	<p class="rx-register__row">
		<label class="rx-register__label" for="reg_username"><?php echo $settings['label_username']; ?></label>
		<input type="text" class="rx-register__input" name="username" id="reg_username" value="<?php echo $username; ?>" placeholder="<?php echo $settings['placeholder_username']; ?>"/>
	</p>

	<p class="rx-register__row">
		<label  class="rx-register__label"  for="rx_email"><?php echo $settings['label_email']; ?></label>
		<input type="email" class="rx-register__input" name="email" id="reg_email" value="<?php echo $email; ?>" placeholder="<?php echo $settings['placeholder_email']; ?>"/>
	</p>

	<p class="rx-register__row">
		<label  class="rx-register__label" for="rx_password"><?php echo $settings['label_pass']; ?></label>
		<input type="password" class="rx-register__input" name="password" id="rx_password" placeholder="<?php echo $settings['placeholder_pass']; ?>"/>
	</p>

	<?php if ( 'yes' === $settings['confirm_password'] ) : ?>

		<p class="rx-register__row">
			<label  class="rx-register__label" for="rx_password_confirm"><?php echo $settings['label_pass_confirm']; ?></label>
			<input type="password" class="rx-register__input" name="password-confirm" id="rx_password_confirm" placeholder="<?php echo $settings['placeholder_pass_confirm']; ?>"/>
			<?php echo '<input type="hidden" name="rx_confirm_password" value="true">'; ?>
		</p>

	<?php endif; ?>

	<p class="rx-register__row rx-register-submit">
		<?php
			wp_nonce_field( 'rx-register', 'rx-register-nonce' );
			printf( '<input type="hidden" name="rx_redirect" value="%s">', $redirect_url );
		?>
		<button type="submit" class="rx-register__submit button" name="register"><?php
			echo $settings['label_submit'];
		?></button>
	</p>

</form>
<?php
include $this->__get_global_template( 'messages' );
