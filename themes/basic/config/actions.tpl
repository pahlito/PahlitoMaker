{include file="./header.tpl"}
<div class="row-fluid">
	<div class="well span4">
		<form name="pick_group" method="get">
			<fieldset>
				<legend>Seleccionar Grupo</legend>
				<table class="table">
					<tr>
						<th>Grupos</th>
						<td>
							<select name="group" class="input-medium">
								{foreach from=$groups item=group}
								<option value="{$group.group_id}" {if $_get.group == $group.group_id }selected="selected" {/if}>{$group.group_name}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr><th colspan="2"><input type="submit" class="btn" value="Cambiar Permisos" /></th></tr>
				</table>
			</fieldset>
		</form>
	</div>
{if !is_null($tables) AND !is_null($actions)}
	<div class="hero-unit">		
		<form name="access" method="post">
			<fieldset>
				<legend>Permisos del grupo:</legend>
				<table class=" table table-bordered table-striped">
					<thead>
						<tr class="actions">
							<th />
							{foreach from=$actions key=action_name item=action_data}
							<th>{$action_name}</th>
							{/foreach}
						</tr>
					</thead>
					<tbody>
						{foreach from=$tables key=table_name item=table_data}
						<tr>
							<th>{$table_data.description}</th>
					 		{foreach from=$actions key=action_name item=action_data}
							<th class="center">
								<div class="btn-group" data-toggle="buttons-radio" data-target="#access_{$table_name}_{$action_name}">
									<a class="btn btn-mini {if $groupCan.$table_name.$action_name eq '1'}active{/if}" data-toggle="button" data-value="1"><span class="icon-ok-sign"></span></a>
									<a class="btn btn-mini {if $groupCan.$table_name.$action_name neq '1'}active{/if}" data-toggle="button" data-value="0"><span class="icon-remove-sign"></span></a>
								</div>
								<input type="checkbox" class="hidden" id="access_{$table_name}_{$action_name}" {if $groupCan.$table_name.$action_name eq '1'}checked="checked"{/if} name="access[{$table_name}][{$action_name}]" />
							</th>
							{/foreach}
						</tr>
						{/foreach}
					</tbody>
					<tfoot>
						<tr>
							{assign var="colspan" value=count($actions)+1 }
							<th colspan="{$colspan}" class="center">
								<input type="submit" class="btn btn-large center" value="Guardar Cambios" />
							</th>
						</tr>
					</tfoot>
				</table>
			</fieldset>
		</form>
		<script>
			$(function(){
				$('.btn-group a').click( function(event){
  					event.preventDefault();
					var input = $(this).parent().attr('data-target');
					if($(this).attr('data-value').toString() == "1")
      					$(input).prop('checked', "checked").change();
      				else
      					$(input).prop('checked', false).change();
   				});
			});
		</script>
	</div>
{/if}
</div>
{include file="./footer.tpl"}