{include file="./header.tpl"}
<div class="row-fluid">
	<div class="well span6">
		<form name="pick_tables">
			<fieldset>
				<legend>Seleccione las tablas</legend>
				<table>
					<tr>
						<th>Tabla</th>
						<td>
							<select name="table">
								{foreach from=$config.tables key=table item=contenido}
								<option value="{$table}" {if $_get.table==$table}selected="selected"{/if} >{$contenido.description}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<th>Tabla Intermedia</th>
						<td>
							<select name="junction_table">
								{foreach from=$config.tables key=table item=contenido}
								<option value="{$table}" {if $_get.junction_table==$table}selected="selected"{/if} >{$contenido.description}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" class="btn" value="Editar Campos Extra" /></td>
					</tr>
				</table>
			</fieldset>
		</form>
	</div>
	{if $_get.table && $_get.junction_table}
	<div class="hero-unit span6">
		<form action="" method="post">
			<input type="hidden" name="type" value="junction" />
			<fieldset>
				<legend>Seleccione las claves</legend>
				<table>
					<tr>
						<th>Nombre para mostrar</th>
						<td>
							<input class="input input-medium" name="description" value="{$description}" />
						</td>
					</tr>
					<tr>
						<th>Clave Primaria</th>
						<td>
							<select name="options[primary_key]">
								{assign	var=elements value=$config.tables[$_get.table].elements}
								{if is_array($elements)}
									{foreach from=$elements key=field item=element}
										<option value="{$field}" {if $options.primary_key==$field}selected="selected"{/if}>{$element.description}</option>
									{/foreach} 
								{/if}
							</select>
						</td>
					</tr>
					<tr>
						<th>Tabla Referenciada</th>
						<td>
							<select name="options[display_table]">
							{foreach from=$config.tables key=table item=contenido}
								<option value="{$table}" {if $options.display_table==$table}selected="selected"{/if}>{$contenido.description}</option>
							{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<th>Clave Referenciada</th>
						<td>
							<input class="input input-medium" name="options[display_key]" value="{$options.display_key}"/>
						</td>
					</tr>
					<tr>
						<th>Campo para Mostrar</th>
						<td>
							<input class="input input-medium" name="options[display_field]" value="{$options.display_field}" />
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" class="btn" value="Guardar" /></td>
					</tr>
				</table>
			</fieldset>
		</form>
	</div>
	{/if}
</div>
{include file="./footer.tpl"}