SELECT departamentos.id_departamento, municipios.id_municipio, cat_tipo_actor.id_tipo_actor, sub_cat_tipo_actor.id_tipo_actores, 
actores_locales.id_actor_local, contactos.id_contacto, cat_area_trabajo.id_area_trabajo, actores_locales.nombre_institucion_organizacion, 
contactos.nombre_contacto, contactos.correo_electronico, contactos.telefono_celular, contactos.cargo, cat_area_trabajo.area_trabajo
FROM cat_area_trabajo INNER JOIN (((cat_tipo_actor INNER JOIN sub_cat_tipo_actor ON cat_tipo_actor.id_tipo_actor = sub_cat_tipo_actor.id_tipo_actor) 
                                   INNER JOIN ((departamentos INNER JOIN municipios on departamentos.id_departamento = municipios.id_departamento) 
                                               INNER JOIN(actores_locales INNER JOIN contactos ON actores_locales.id_actor_local = contactos.id_actor_local) 
                                               ON (municipios.id_municipio = actores_locales.id_municipio) AND (municipios.id_departamento = actores_locales.id_departamento)) 
                                   ON (sub_cat_tipo_actor.id_tipo_actor = actores_locales.id_tipo_actor) AND (sub_cat_tipo_actor.id_tipo_actores = actores_locales.id_tipo_actores)) 
                                  INNER JOIN areas_trabajo_actor on actores_locales.id_actor_local = areas_trabajo_actor.id_actor_local) 
                                  ON cat_area_trabajo.id_area_trabajo = areas_trabajo_actor.id_area_trabajo

