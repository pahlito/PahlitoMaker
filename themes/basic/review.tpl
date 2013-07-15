{include file="./header.tpl"}
	{if isset($form)}
		<table class="center">
			<caption>{$form.description}</caption>
			{foreach from=$form.elements item=element}
				{assign var="type" value=$element->type}
				<tr>
					<th>{$element->description}</th>
					<td>
						{if is_array($element->options)}
							{if 'junction'== $element->type}
								{foreach from=$element->options item=option}
									{if $option.saved}{$option.description}<br>{/if}
								{/foreach}
							{/if}
							{foreach from=$element->options item=option}
								{if $option.value==$element->value}{$option.description}{/if}
							{/foreach}
						{else}
							{$element->value}
						{/if}
					</td>
				</tr>
			{/foreach}
		</table>
	{/if}
{include file="./footer.tpl"}
