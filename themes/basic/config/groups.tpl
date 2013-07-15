{include file="./header.tpl"}
{if isset($_get.new)||$group_id}
<div class="row-fluid">
	<div class="well span6">
		<form method="post">
			<input type="hidden" name="group_id" value="{$group_id}"/>
			<fieldset>
			<legend>{if !$group_id}Agregar{else}Editar{/if} Grupo</legend>
			<table class="table">
				<tr>
					<th>Nombre del {if !$group_id}nuevo{/if} Grupo</th>
					<td><input class="input-medium" name="group_name" value="{$group_name}" /></td>
				</tr>
				<tr>
					<th colspan="2">
						<input type="submit" class="btn" value="Guardar" />
					</th>
				</tr>
			</table>
			</fieldset>
		</form>
	</div>

{/if}
<div class="hero-unit span6">
	<table class="table table-bordered table-striped">
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Usuarios</th>
			<th />
		</tr>
		{foreach from=$groups item=group}
		<tr>
			<td>{$group.group_id }</td>
			<td>{$group.group_name}</td>
			<td>{$group.group_users }</td>
			<td>
				<a href="?group={$group.group_id}">Editar</a>
				{if (!$group.group_users)}<a href="?delete={$group.group_id}">Borrar</a>{/if}
			</td>
		</tr>
		{/foreach}
	</table>
	<a href="?new" class="btn" >Agregar Grupo</a>
</div>
</div>
{include file="./footer.tpl"}