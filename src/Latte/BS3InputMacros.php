<?php

namespace BS3FormRenderer\Latte\Macros;

use Nette\Forms\Controls\Button;
use Nette\Forms\Controls\Checkbox;
use Nette\Forms\Controls\ChoiceControl;
use Nette\Forms\Controls\ImageButton;
use Nette\Forms\Controls\SelectBox;
use Nette\Forms\Controls\TextBase;
use Nette\Utils\Html;
use Nette\Forms\Controls\BaseControl;
use Nextras;


class BS3InputMacros extends BaseInputMacros
{
    /**
     * @param BaseControl $control
     * @return Nextras\Forms\Rendering\Bs3FormRenderer
     */
    public static function getRenderer(BaseControl $control)
    {
        return $control->getForm()->getRenderer();
    }

	public static function label(Html $label, BaseControl $control)
	{
        return $label;
	}


	public static function input(Html $input, BaseControl $control)
	{
		$name = $input->getName();
		if ($name === 'select' || $name === 'textarea' || ($name === 'input' && !in_array($input->type, array('radio', 'checkbox', 'file', 'hidden', 'range', 'image', 'submit', 'reset')))) {
			$input->addClass('form-control');

		} elseif ($name === 'input' && ($input->type === 'submit' || $input->type === 'reset')) {
			$input->setName('button');
			$input->add($input->value);
			$input->addClass('btn');
		}

		return $input;
	}

    public static function pair(BaseControl $control)
    {

        $label = $control->getLabel();
        $inp = $control->getControl();



        $renderer = self::getRenderer($control);

        $html = Html::el($renderer->wrappers['pair']['container']);
        if($label) {
            $html->add(Html::el($renderer->wrappers['label']['container'], ['class' => ($control->isRequired()?'required':'')])
                ->add(self::label($label, $control)));
        }

        $html->add(Html::el($renderer->wrappers['control']['container'])->add(self::input($inp, $control)));

        return $html;
    }

}
