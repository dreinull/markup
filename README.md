# Markup
This is a small class for creating forms quickly in PHP. Easy to use with Twitter Bootstrap.

##Opening a Form
For *opening a form* you can use `Form::open('url/to/go', $attributes);`

$attributes is an array used in the HTML tag. The defaults are:

```
[
    'method' => 'POST',
    'file' => false,
    'class' => null,
    'accept-charset' => 'UTF-8',
];
```

If you set 'file' to true it will ctreate a <form enctype="multipart/form-data"> tag. Besides you can add any attribute (like id) in the array.

To *close a form* just use `Form::close();`.

##Create Inputs

Let's begin with creating a simple *text input*:

```
Form::text('username', 'Your username', $default, ['class' => 'my-class']); 
```
generates the following:
```
<div class="input-text">
  <label for="username">Your username</label>
  <input type="text" name="username" value="My Default" class="my-class">
</div>
```
The attributes are in order
* The name attribute of the input
* A label
* A default value (use `null` if it has to be empty)
* An array of attributes for the input tag. You can use them with `key => value` as seen above or just add values without a key (like `disabled`).

If you just want to get the input tag without a label and the wrapper you can use

```
Form::textInput('username', $default, ['class' => 'my-class']);
```

If you just want to get rid of the label, set the second argument to null.

The are more inputs using the same syntax:
* `Form::textarea($name, $label, $input, $attributes)`
* `Form::email($name, $label, $input, $attributes)`
* `Form::password($name, $label, $attributes)` (Without default value)
* `Form::file($name, $label, $attributes)` (Without default value)
* `Form::textarea($name, $input, $attributes)` (Without label)

##More inputs
`Form::select($name, $options, $default, $attributes);` creates a select tag. $options is an array of selectable options with `$value => $name`. You can set $default with one of the $value names.

`Form::radio($name, $value, $description, $checked, $attributes);` creates a radio button. $checked is a boolean.

`Form::checkbox(§name, $label, $value, $checked);` created a checkbox. Defaults are: $value = 1, $checked = 0

##Submitting a Form

`Form::submit('Submit', 'success');` creates the following:
```
<div class="input-submit">
  <button type="submit" class="btn btn-success">
</div>
```

The class is completed with 'btn-'.

If you want to get rid of the wrapper you can use
`Form::submitButton('submit', 'success');`
