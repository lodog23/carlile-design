<div class="footer__social">

<?php if( have_rows('qd_social_media_accounts', 'options') ): ?>
		<div class="socialAccounts">
			<?php while( have_rows('qd_social_media_accounts', 'options') ): the_row();
				// vars
				$accountType = get_sub_field('qd_account_type', 'options');
				$accountURL = get_sub_field('qd_account_link', 'options');
				?>
				<div class="socialAccount">
						<a href="<?php echo $accountURL; ?>" target="_blank" aria-label="Link to <?php echo $accountType; ?> Account"><i class="fab fa-<?php echo $accountType; ?>"></i></a>
				</div>
			<?php endwhile; ?>
		</div> <!-- socialAccounts -->
		<?php endif; ?>

</div> <!-- footer__social -->
