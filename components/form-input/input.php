/**
 * input
 *
 * @param  mixed $name
 * @param  mixed $type
 * @param  mixed $id
 * @return void
 */
function input($name, $id, $type, $value = '') { 
	if ($type == 'hidden') : ?>
		<input type="<?= $type ?>" id="<?= $id ?>" name="<?= $id ?>" value="<?= $value ?>">

	<?php elseif ($type == 'textarea') : ?>
		<label class="form-group">
			<textarea id="<?= $id ?>" name="<?= $id ?>" value="<?= $value ?>" placeholder="&nbsp;"></textarea>
			<span class="txt"><?= $name ?> <sup>*</sup></span>
			<span class="bar"></span>
		</label>

	<?php else: ?>
		<label class="form-group">
			<input type="<?= $type ?>" id="<?= $id ?>" value="<?= $value ?>" name="<?= $id ?>" placeholder="&nbsp;">
			<span class="txt"><?= $name ?> <sup>*</sup></span>
			<span class="bar"></span>
		</label>
<?php
	endif;
}
