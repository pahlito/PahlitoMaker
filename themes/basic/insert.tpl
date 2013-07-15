{include file="./header.tpl"}
	{if isset($form)}
	<form action="" method="post">
		<table class="center">
			<caption>Añadir {$form.description}</caption>
			{foreach from=$form.elements item=element}
				{assign var="type" value=$element->type}
				<tr>
					<th>{$element->description}</th>
					<td>{include file="./elements/$type.tpl" }</td>
				</tr>
			{/foreach}
			<tr>
				<th colspan="2"><input type="submit" value="Guardar" /></th>
			</tr>
		</table>
	</form>
	{/if}
{include file="./footer.tpl"}