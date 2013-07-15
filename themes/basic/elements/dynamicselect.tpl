<select name="{$element->name}">
	{foreach from=$element->options item=option}
		<option value="{$option.value}">{$option.description}</option>	
	{/foreach}
</select>