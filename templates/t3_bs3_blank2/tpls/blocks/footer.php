<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if ($this->checkSpotlight('footnav', 'footer-1, footer-2, footer-3, footer-4, footer-5, footer-6') || $this->checkSpotlight('footnavtop', 'footer-7, footer-8, footer-9, footer-10') || $this->countModules('footer') ) : ?>

<!-- FOOTER -->
<footer id="t3-footer" class="wrap t3-footer">
 <p id="back-top">
    	<a href="#top" title="Go to Top"><i class="fa fa-caret-up"></i></a>
 </p>
	<?php if ($this->checkSpotlight('footnavtop', 'footer-7, footer-8, footer-9, footer-10')) : ?>
    <aside id="t3footnav-top">
		<!-- FOOT NAVIGATION top -->
		<div class="container">
			<?php $this->spotlight('footnavtop', 'footer-7, footer-8, footer-9, footer-10') ?>
		</div>
		<!-- //FOOT NAVIGATION top -->
        </aside>

	<?php endif ?>
	<?php if ($this->checkSpotlight('footnav', 'footer-1, footer-2, footer-3, footer-4, footer-5, footer-6')) : ?>
    <aside id="t3footnav">
		<!-- FOOT NAVIGATION -->
		<div class="container">
			<?php $this->spotlight('footnav', 'footer-1, footer-2, footer-3, footer-4, footer-5, footer-6') ?>
		</div>
		<!-- //FOOT NAVIGATION -->
        </aside>

	<?php endif ?>
    <?php if ($this->countModules('footer')) : ?>
	<section class="t3-copyright">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<jdoc:include type="modules" name="<?php $this->_p('footer') ?>" />
				</div>
				<?php /*?><?php if ($this->getParam('t3-rmvlogo', 1)): ?>
					<div class="col-md-4 poweredby text-hide">
						<a class="t3-logo t3-logo-color" href="http://t3-framework.org" title="Powered By T3 Framework"
						   target="_blank" <?php echo method_exists('T3', 'isHome') && T3::isHome() ? '' : 'rel="nofollow"' ?>>Powered by <strong>T3 Framework</strong></a>
					</div>
				<?php endif; ?><?php */?>
			</div>
		</div>
	</section>
<?php endif ?>
</footer>
<!-- //FOOTER -->

<?php endif ?>

