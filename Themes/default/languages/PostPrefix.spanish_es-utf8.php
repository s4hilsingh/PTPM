<?php

/**
 * @package SMF Post Prefix
 * @version 1.0
 * @author Diego Andrés <diegoandres_cortes@outlook.com>
 * @copyright Copyright (c) 2015, Diego Andrés
 * @license http://www.mozilla.org/MPL/MPL-1.1.html
 */

// Admin Tabs
$txt['PostPrefix_main'] = 'PostPrefix';
$txt['PostPrefix_tab_general'] = 'General';
$txt['PostPrefix_tab_general_desc'] = 'Entérate que hay de nuevo con SMF Post Prefix';
$txt['PostPrefix_tab_prefixes'] = 'Prefijos';
$txt['PostPrefix_tab_prefixes_desc'] = 'Lista de prefijos disponibles';
$txt['PostPrefix_tab_prefixes_add'] = 'Agregar Prefijo';
$txt['PostPrefix_tab_prefixes_add_desc'] = 'Agrega un nuevo prefijo, puedes ajustar el nombre, color y seleccionar los foros y grupos con permisos.';
$txt['PostPrefix_tab_prefixes_edit_desc'] = 'Editar el prefijo actual, puedes ajustar el nombre, color y seleccionar los foros y grupos con permisos.';
$txt['PostPrefix_tab_settings'] = 'Ajustes';
$txt['PostPrefix_tab_prefixes_edit'] = 'Editar Prefijo';
$txt['PostPrefix_tab_require'] = 'Requerido';
$txt['PostPrefix_tab_require_desc'] = 'Aquí puedes seleccionar en que foros el prefijo será requerido/forzado.';
$txt['PostPrefix_tab_permissions'] = 'Permisos';
$txt['PostPrefix_tab_permissions_desc'] = 'Permisos para SMF Post Prefix mod.';
$txt['PostPrefix_tab_settings'] = 'Ajustes';
$txt['PostPrefix_tab_settings_desc'] = 'Ajustes generales de prefijos.';

// General
$txt['PostPrefix_donate_title'] = 'Donate to the author';
$txt['PostPrefix_version'] = 'PostPrefix version';
$txt['PostPrefix_main_credits'] = 'Credits';

// Prefixes
$txt['PostPrefix_no_prefixes'] = 'No has agregado ningún prefijo';
$txt['PostPrefix_prefix_name'] = 'Nombre';
$txt['PostPrefix_prefix_id'] = 'ID';
$txt['PostPrefix_prefix_icon'] = 'Ícono';
$txt['PostPrefix_prefix_modify'] = 'Modificar';
$txt['PostPrefix_prefix_status'] = 'Estado';
$txt['PostPrefix_prefix_date'] = 'Fecha';
$txt['PostPrefix_prefix_modify'] = 'Modificar';
$txt['PostPrefix_prefix_groups'] = 'Groupos';

// Add/Edit
$txt['PostPrefix_prefix_enable'] = '¿Activar prefijo?';
$txt['PostPrefix_prefix_color'] = '¿Usar color?';
$txt['PostPrefix_prefix_icon_use'] = '¿Usar ícono en lugar de texto?';
$txt['PostPrefix_prefix_icon_url'] = 'URL del ícono';
$txt['PostPrefix_add_prefix'] = 'Agregar prefijo';
$txt['PostPrefix_save_prefix'] = 'Actualizar prefijo';
$txt['PostPrefix_prefix_groups'] = 'Grupos permitidos';
$txt['PostPrefix_select_visible_groups'] = 'Mostrar grupos';
$txt['PostPrefix_prefix_groups_desc'] = 'Grupos que tienen permiso de usar el prefijo';
$txt['PostPrefix_prefix_boards'] = 'Utilizable en';
$txt['PostPrefix_select_visible_boards'] = 'Mostrar foros';
$txt['PostPrefix_prefix_boards_desc'] = 'Foros en los que el prefijo puede ser utilizado';
$txt['mboards_groups_regular_members'] = 'Este grupo contiene a todos los usuarios que no tienen un grupo primario asignado.';
$txt['mboards_groups_post_group'] = 'Este grupo es un gropo basado en conteo de mensajes.';
$txt['PostPrefix_use_bgcolor'] = '¿Usar color como color de fondo?';
$txt['PostPrefix_prefix_boards_require'] = 'Requerir prefijo en';
$txt['PostPrefix_prefix_boards_require_desc'] = 'Foros en donde el prefijo será requerido';
$txt['PostPrefix_required_updated'] = 'Foros requeridos actualizados exitósamente.';
$txt['PostPrefix_prefix_added'] = 'El prefijo %s fue agregado con éxito.';
$txt['PostPrefix_prefix_updated'] = 'El prefijo %s fue actualizado satisfactoriamente.';
$txt['PostPrefix_prefix_delete_sure'] = '¿Estás seguro de que deseas eliminar los prefijos seleccionados?';
$txt['PostPrefix_prefix_deleted'] = 'Los prefijos seleccionados previamente fueron eliminados con éxito..';

// Error
$txt['PostPrefix_error_noprefix'] = 'Tienes que especificar al menos el nombre del prefijo';
$txt['PostPrefix_empty_groups'] = 'No hay grupos seleccionados para este prefijo.';
$txt['PostPrefix_empty_boards'] = 'No hay foros seleccionados para este prefijo.';
$txt['PostPrefix_error_unable_tofind'] = 'Imposible encontrar un prefijo';
$txt['error_no_prefix'] = 'No se seleccionó un prefijo.';

// Permissions
$txt['permissionname_manage_prefixes'] = 'Configurar prefijos';
$txt['groups_manage_prefixes'] = 'Configurar prefijos';
$txt['permissionhelp_manage_prefixes'] = 'Determina si el usuario puede manejar los prefijos.';
$txt['permissionhelp_groups_manage_prefixes'] = 'Determina si el usuario puede manejar los prefijos.';
$txt['cannot_manage_prefixes'] = 'No tienes permiso para administrar los prefijos.';
$txt['permissionname_set_prefix'] = 'Usar Prefijos';
$txt['groups_set_prefix'] = 'Usar Prefijos';
$txt['permissionhelp_set_prefix'] = 'Determina si el usuario puede asignar un prefijo a sus temas.';
$txt['permissionhelp_groups_set_prefix'] = 'Determina si el usuario puede asignar un prefijo a sus temas.';
$txt['cannot_set_prefix'] = 'No tienes permiso para utilizar los prefijos.';

// Settings
$txt['PostPrefix_enable_filter'] = 'Activar filtro por prefijos';
$txt['PostPrefix_enable_filter_desc'] = 'Mostrará una caja que te permitirá filtrar los temas por prefijo.';
$txt['PostPrefix_select_order'] = 'Orden de prefijos';
$txt['PostPrefix_select_order_desc'] = 'El orden que la lista de prefijos tendrá al crear un tema.';
$txt['PostPrefix_select_order_dir'] = 'Dirección';
$txt['PostPrefix_select_order_dir_desc'] = 'DESC, ASC';
$txt['PostPrefix_DESC'] = 'DESC';
$txt['PostPrefix_ASC'] = 'ASC';

// Post
$txt['PostPrefix_select_prefix'] = 'Seleccionar Prefijo';
$txt['PostPrefix_prefix'] = 'Prefijo';
$txt['PostPrefix_prefix_none'] = '[Sin Prefijo]';

// Filter by prefix
$txt['PostPrefix_filter'] = 'Filtrar por Prefijo';
$txt['PostPrefix_filter_noprefix'] = 'Sin Prefijo';
$txt['PostPrefix_filter_all'] = 'Mostrar todos los temas.';