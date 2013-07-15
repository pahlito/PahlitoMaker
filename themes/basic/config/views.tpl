{include file="./header.tpl"}
<div class="row-fluid">
	<div class="well span5">
		<form name="pick_table">
			<fieldset>
			<legend>Tablas Relacionadas</legend>
				<table class="table">
					<tr>
						<th>Tabla</th>
						<td>
							<select name="table">
								{foreach from=$config.tables key=table item=contenido}
								<option value="{$table}" {if $_get.table==$table}selected="selected"{/if}>{$contenido.description}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<th>Tabla Referenciada</th>
						<td>
							<select name="view_table">
								{foreach from=$config.tables key=table item=contenido}
								<option value="{$table}" {if $_get.view_table==$table}selected="selected"{/if} >{$contenido.description}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" class="btn" value="Editar Vistas" /></td>
					</tr>
				</table>
			</fieldset>
		</form>
	</div>
	{if $_get.table&&$_get.view_table}
	<div class="hero-unit span7">
		<form action="" method="post">
			<fieldset>
			<legend>Relaciones</legend>
			<table class="table">
				<tr>
					<th>Campo relacionado de {$_get.table}:</th>
					<td>
						<select name="ref_key">
							{foreach from=$config.tables[$_get.table].elements key=field item=element}
							<option value="{$field}" {if $view.ref_key==$field}selected="selected"{/if}>{$field}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<th>Nombre de la vista:</th>
					<td><input name="description" value="{$view.description}"/></td>
				</tr>
				<tr>
					<th>Clave foránea de {$_get.view_table}:</th>
					<td>
						<select name="rel_key">
							{foreach from=$config.tables[$_get.view_table].elements key=field item=element}
							<option value="{$field}" {if $view.rel_key==$field}selected="selected"{/if}>{$field}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
					<strong>Campos a mostrar:</strong><br/>
					{foreach from=$config.tables[$_get.view_table].elements key=field item=element}
					<label for="{$field}" class="btn">{$field}
						<input type="checkbox" class="checkbox" name="fields[]" id="{$field}" value="{$field}" {if in_array($field, $view.fields)}checked="checked"{/if} />
					</label>
					{/foreach}
					</td>
				</tr>
				<tr colspan="2"><th colspan="2"><input name="save" type="submit" class="btn" value="Guardar Cambios" /></td></tr>
			</table>
			</fieldset>
		</form>
	</div>
	{/if}
</div>
{include file="./footer.tpl"}