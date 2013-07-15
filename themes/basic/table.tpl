{include file="./header.tpl"}
	<table class="center main_table">
		{if isset($fields)}
		<thead>
			<tr>
				{foreach from=$fields item=field}
				<th id="{$field.id}">{$field.description}</th>
				{/foreach}
				<th />
			</tr>
		</thead>
		{/if}
		{if isset($rows)}
		<tbody>
			{foreach from=$rows item=row}
			<tr id="row_{$row.id}">
				{foreach from=$row.values item=value}
					<td>{$value}</td>
				{/foreach}						
				<td>
					<div class="row_links">						
					{foreach from=$row.links item=link}
						<a href="{$link.href}" class="{$link.action}">{$link.description}</a>
					{/foreach}
					</div>
				</td>
			</tr>
			{/foreach}
		</tbody>
		{/if}
	</table>
	<div class="action_links">
	{foreach from=$links item=link}
		<a href="{$link.href}" class="$link.action">{$link.description}</a>
	{/foreach}
	</div>
{include file="./footer.tpl"}