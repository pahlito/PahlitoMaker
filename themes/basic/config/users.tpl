{include file="./header.tpl"}
<div class="row-fluid">
	<div class="well span5">
	<form name="pick_group" method="get">
		<legend>Seleccione un grupo</legend>
		<table class="table">
			<tr>
				<th>Grupo</th>
				<td>
					<select name="group">
						{foreach from=$groups item=group}
						<option value="{$group.group_id}" {if $group.group_id==$group_id}selected="selected"{/if}>{$group.group_name}</option>
						{/foreach}
					</select>
				</td>
			</tr><tr>
				<th colspan="2"><input type="submit" class="btn" value="Ver Usuarios" /></th>
			</tr>
		</table>
	</form>
	</div>
{if isset($_get.new)||isset($user)}
	<div class="hero-unit span7">
		<form method="post">
			<input type="hidden" name="user_id" value="{$user.user_id}">
			<table class="table">
				<tr>
					<th>Email</th>
					<td><input name="user_email" value="{$user.user_email}" /></td>
				</tr>
				<tr>
					<th>Password</th>
					<td>
						<input name="user_pass" value="" /><br/>
						<small>Dejar en blanco para {if isset($_get.new)}generación automática.{else}conservar el actual.{/if}<small>
					</td>
				</tr>
				<tr>
					<th>Grupo</th>
					<td>
						<select name="group_id">
							{foreach from=$groups item=group}
							<option value="{$group.group_id}" {if $user.group_id==$group_id}selected="selected"{/if}>{$group.group_name}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" class="btn" value="guardar" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>
{/if}
{if isset($users)}
<div class="well well-large">
	<table class="table table-bordered table-striped">
		<tr>
			<th>ID</th>
			<th>Email</th>
			<th />
		</tr>
		{if count($users)}
			{foreach from=$users item=user}
			<tr>
				<td>{$user.user_id}</td>
				<td>{$user.user_email}</td>
				<td>
					<a href="?user={$user.user_id}">Editar</a>
					{if $user.user_id!=Session::getSessionData('user_id')}
						<a href="?delete={$user.user_id}">Borrar</a>
					{/if}
				</td>
			</tr>
			{/foreach}
		{else}
		<tr>
			<td class="empty" colspan="2">No hay usuarios en este grupo</td>
		</tr>
		{/if}
	</table>	
	<a href="?new" class="btn rigth_link">Agregar Usuario</a>
</div>
{/if}
{include file="./footer.tpl"}