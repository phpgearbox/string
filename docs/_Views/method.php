# <?= $this->v('method.name') ?>

<?php if ($this->v('method.summary') != ''): ?>
<?= $this->v('method.summary') ?>

<?php endif; ?>

## Description
`<?= $this->v('method.return.type') ?> <?= $this->v('method.name') ?>
(<?php foreach($this->a('method.parameters') as $x => $parameter): ?>
<?= $parameter['type'] ?> $<?= $parameter['name'] ?>
<?php if ($parameter['default'] != ''): ?> = <?php if ($parameter['type'] == 'string'): ?>'<?php endif; ?>
<?= $parameter['default'] ?><?php if ($parameter['type'] == 'string'): ?>'<?php endif; ?><?php endif; ?>
<?php if ($x+1 < count($this->a('method.parameters'))): ?>, <?php endif; ?>
<?php endforeach; ?>)`
<?php if ($this->v('method.description') != ''): ?>

<?= trim($this->v('method.description')) ?>

<?php endif; ?>

<?php if (count($this->a('method.parameters')) > 0): ?>
### Parameters
<?php foreach($this->a('method.parameters') as $parameter): ?>
* _<?= $parameter['type'] ?>_ __$<?= $parameter['name'] ?>__<?= '  ' ?>

<?= $parameter['description'] ?>


<?php endforeach; ?>
<?php endif; ?>

### Return Value
_<?= $this->v('method.return.type') ?>_<?= '  ' ?>

<?= $this->v('method.return.description') ?>

<?php if (count($this->a('method.exceptions')) > 0): ?>
### Errors/Exceptions
<?php foreach($this->a('method.exceptions') as $exception): ?>
* _<?= $exception['type'] ?>_<?= '  ' ?>

<?= $exception['description'] ?>


<?php endforeach; ?>
<?php endif; ?>

<?= $this->v('method.merge') ?>
