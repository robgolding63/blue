<?php // Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p>This post is password protected. Enter the password to view comments.</p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'class="alt" ';
?>

<!-- You can start editing here. -->

<div id="comments">

<?php if ($comments) : ?>
	
	
	<h2><?php comments_number('No Responses', 'One Response', '% Responses' );?> to <?php the_title(); ?></h2>
	
	<?php $first = true; ?>
	
	<?php foreach ($comments as $comment) : ?>

		<div class="comment <?php if ($first) { echo 'first'; } ?>" id="comment-<?php comment_ID() ?>">
			<div class="meta">
				<?php echo get_avatar( $comment, 96 ); ?>
				<p>
					<?php if ($comment->user_id) { 
						$user=get_userdata($comment->user_id); echo $user->display_name;
					} else { 
						comment_author_link();
					} ?>
				</p>
				<p>
					<?php comment_date('F jS, Y') ?> at <?php comment_time() ?> <?php edit_comment_link('edit &rarr;','',''); ?>
				</p>
			</div>
			<div class="text">
				<?php if ($comment->comment_approved == '0') : ?>
					<p><strong>Your comment is awaiting moderation.</strong></p>
				<?php endif; ?>
				<p class="meta"></p>
				<?php comment_text() ?>
			</div>
		</div>
		
		<?php $first = false; ?>

	<?php endforeach; /* end for each comment */ ?>
	
 <?php else : // this is displayed if there are no comments so far ?>
	
	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p>Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>

</div> <!-- /comments -->

<?php if ('open' == $post->comment_status) : ?>

<div id="comments_reply" <?php if ($comments) : ?> style="border-top: 0" <?php endif; ?>>

	<h2>Leave a Reply</h2>

	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p>
			You must be
			<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a>
			to post a comment.
		</p>
	<?php else : ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

		<div class="form comments-form">

			<?php if ( $user_ID ) : ?>

				<p class="meta">
					Logged in as
					<a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>.
					<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Log out &raquo;</a>
				</p>
			<?php else : ?>
				<div class="field-wrapper">
					<div class="label"><label for="author">Name <?php if ($req) echo "*"; ?></label></div>
					<div class="field"><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> /></div>
				</div>

				<div class="field-wrapper">
					<div class="label"><label for="email">Mail <?php if ($req) echo "*"; ?></label></div>
					<div class="field"<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> /></div>
				</div>

				<div class="field-wrapper">
					<div class="label"><label for="url">Website</label></div>
					<div class="field"><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /></div>
				</div>
			<?php endif; ?>
				<!-- <p><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></p> -->
				<div class="field-wrapper">
					<div class="field"><textarea name="comment" id="comment" cols="70%" rows="10" tabindex="4"></textarea></div>
					<div class="help"><a href="http://daringfireball.net/projects/markdown/syntax" title="Markdown Syntax" target="_blank">Markdown syntax</a>
					is supported in comments, just indent code with four spaces.</div>
				</div>

				<input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
				<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
				<?php do_action('comment_form', $post->ID); ?>
		</div>
		</form>
	<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
