<?php

use Rezfusion\Partial;
use Rezfusion\Templates;

/**
 * Render opening HTML part of modal component.
 * 
 * @param string $modalId
 * 
 * @return string
 */
function rezfusion_modal_open($modalId = ''): string
{
  return (new Partial(Templates::modalOpenPartial()))->render(['modalId' => $modalId]);
}

/**
 * Render closing HTML part of modal component.
 * 
 * @return string
 */
function rezfusion_modal_close(): string
{
  return (new Partial(Templates::modalClosePartial()))->render([]);
}
