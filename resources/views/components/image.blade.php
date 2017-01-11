<div class="form-group {{ (isset($field['class']) ? $field['class'] : '') }}">
	{{ \Form::label($field['name'], $field['title'], ['class' => 'control-label col-xs-12']) }}
	<div class="col-xs-12">
		<input type="file" name="{{ $field['name'] }}" />

		<img src="{{ url($value) }}" style="max-height: 400px">
	</div>
</div>