<table>
	{foreach from=$element->options item=option}
	<tr><td><input type="checkbox" name="{$element->name}[]" value="{$option.value}" {if $option.saved}checked="checked"{/if}></td><td>{$option.description}</td></tr>
	{/foreach}
</table>