<?php

namespace Markup;

class Form {

    /**
     * Erstellt einen <form>-Tag
     * @param string $action
     * @param array $settings
     * @return string
     */
    public static function open($action = '', $settings = []) {
        /*
         * Ersetzt nicht angegebene Einstellungen durch die Standards
         */
        $defaults = [
            'method' => 'POST',
            'file' => false,
            'class' => null,
            'accept-charset' => 'UTF-8',
        ];
        $settings = array_merge($defaults, $settings);

        /*
         * Erstellt die Attribute
         */
        $settings['action'] = $action;
        if ($settings['file'] == true)
            $settings['enctype'] = 'multipart/form-data';
        unset($settings['file']);
        /*
         * Erstellt einen Tag und gibt ihn zurück
         */
        return Html::createTag('form', $settings);
    }

    /**
     * Schließt die Form
     * @return string
     */
    public static function close() {
        return '</form>';
    }

    /**
     * Erstellt ein Label
     * @param string $name
     * @param string $label
     * @return string
     */
    public static function label($name, $label) {
        return Html::createTag('label', ['for' => $name], $label);
    }

    /**
     * Erstellt ein Textfeld mit Label und Wrapper
     * @param string $name
     * @param string $label
     * @param string $input
     * @return string
     */
    public static function text($name, $label = null, $input = '', $attributes = []) {
        if ($label != null) {
            $label = Form::label($name, $label);
        }
        $input = Form::textInput($name, $input, $attributes);

        return Html::createTag('div', ['class' => 'input-text'],
            $label . $input
        );

    }

    /**
     * Erstellt einen Text-Input mit altem Wert
     * @param string $name
     * @param string $input
     * @param array $attributes
     * @return string
     */
    public static function textInput($name, $input = '', $attributes = []) {
        $value = function_exists('old') && strlen(old($name)) > 0 ? old($name) : $input;
        return Html::createTag('input', array_merge(
            ['type' => 'text', 'name' => $name, 'value' => $value],
            $attributes
        ));
    }

    /**
     * Erstellt eine Textarea mit Label und Input
     *
     * @param $name
     * @param string|null $label
     * @param string $input
     * @return string
     */
    public static function textarea($name, $label = null, $input = '', $attributes = []) {
        if ($label != null) {
            $label = Form::label($name, $label);
        }
        $input = Form::textareaInput($name, $input, $attributes);

        return Html::createTag('div', ['class' => 'input-textarea'],
            $label . $input
        );
    }

    /**
     * Erstellt eine Textarea
     *
     * @param string $name
     * @param string $input
     * @param array $attributes
     * @return string
     */
    public static function textareaInput($name, $input = '', $attributes = []) {
        $attributes['name'] = $name;
        return Html::createTag('textarea', $attributes, $input, true);
    }


    /**
     * Erstellt ein E-Mail-Feld mit Label und Wrapper
     * @param string $name
     * @param string $label
     * @return string
     */
    public static function email($name, $label) {
        $label = Form::label($name, $label);
        $input = Form::emailInput($name);

        return Html::createTag('div', ['class' => 'input-text'],
            $label . $input
        );

    }

    /**
     * Erstellt einen E-Mail-Input mit altem Wert
     * @param string $name
     * @return string
     */
    public static function emailInput($name) {
        $old = function_exists('old') ? old($name) : '';
        return Html::createTag('input', ['type' => 'email', 'name' => $name, 'value' => $old]);
    }

    /**
     * Erstellt ein Passwort-Feld mit Label und Wrapper
     * @param string $name
     * @param string $label
     * @return string
     */
    public static function password($name, $label, $attributes = []) {
        $label = Form::label($name, $label);
        $input = Form::passwordInput($name, $attributes);

        return Html::createTag('div', ['class' => 'input-text'],
            $label . $input
        );
    }

    /**
     * Erstellt einen Passwort-Input
     * @param string $name
     * @return string
     */
    public static function passwordInput($name = 'password', $attributes = []) {
        $attributes['type'] = 'password';
        $attributes['name'] = $name;
        return Html::createTag('input', $attributes);
    }

    /**
     * Erstellt einen Datei-Input
     * @param string $name
     * @param string $label
     * @return string
     */
    public static function file($name, $label, $attributes = []) {
        $attributes['type'] = 'file';
        $attributes['name'] = $name;

        $label = Form::label($name, $label);
        $input = Html::createTag('input', $attributes);
        return Html::createTag('div', ['class' => 'input-file'], $label . $input);
    }

    /**
     * Erstellt ein hidden-Field
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @return string
     */
    public static function hidden($name, $value = null, $attributes = []) {
        $attributes['type'] = 'hidden';
        $attributes['name'] = $name;
        $attributes['value'] = $value;
        return Html::createTag('input', $attributes);
    }

    /**
     * @param string $name
     * @param array $options
     * @param null $default
     * @param array $attributes
     * @return string
     */
    public static function select($name, $options = [], $default = null, $attributes = []) {
        $attributes['name'] = $name;
        $opts = '';
        foreach ($options as $value => $name) {
            if($value === $default) {
                $opts .= Html::createTag('option', ['value' => $value, 'selected'], $name, true);
            } else {
                $opts .= Html::createTag('option', ['value' => $value], $name, true);
            }
        }
        return Html::createTag('select', $attributes, $opts, true);
    }

    public static function radio($name, $value, $description, $checked = false, $attributes = []) {
        $attributes['type'] = 'radio';
        $attributes['name'] = $name;
        $attributes['value'] = $value;
        if ($checked) {
            $attributes[] = 'checked';
        }
        return Html::createTag('label', [],
            Html::createTag('input', $attributes) . ' ' . $description
        );
    }

    public static function checkbox($name, $label, $value = 1, $checked = 0) {
        $attributes = [
            'type' => 'checkbox',
            'name' => $name,
            'value' => $value
        ];
        if($checked != 0 && $checked != null) {
            $attributes[] = 'checked';
        }
        $input = Html::createTag('input', $attributes);
        return Html::createTag('label', [], $input . ' ' . $label, true);
    }

    /**
     * Erstellt einen Button inkl Wrapper
     * @param string $text
     * @param string $class
     * @return string
     */
    public static function submit($text, $class = null) {
        return Html::createTag('div', ['class' => 'input-submit',],
            Form::submitButton($text, $class)
        );
    }

    /**
     * Erstellt eine Button
     * @param string $text
     * @param string $class
     * @return string
     */
    public static function submitButton($text, $class) {
        $class = $class != null ? 'btn btn-' . $class : 'btn';
        return Html::createTag('button', ['type' => 'submit', 'class' => $class], $text);
    }

}