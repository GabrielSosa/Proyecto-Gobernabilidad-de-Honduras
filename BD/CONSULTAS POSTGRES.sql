BUSCAR DEPARTAMENTOS
SELECT * FROM "Departamentos" WHERE "Seleccionado" = 'true'

BUSCAR NOMBRE DE LA ORGANIZACION
SELECT   "Nombre de la Institución/Organización:" FROM public."Actores_Locales";

DATOS DE CONTACTO:
SELECT "Id_Actor_Local", "Id_Contacto", "Nombre del contacto", "Cargo", "Correo electrónico", "Teléfono_celular" FROM public."Contactos";

DATOS DE LA TABLA DE BUSQUEDA:

SELECT  A."Id_Actor_Local", A."Nombre de la Institución/Organización:", B."Nombre del contacto", B."Correo electrónico", B."Teléfono_celular"
FROM "Actores_Locales" A INNER JOIN "Contactos" B ON A."Id_Actor_Local"= B."Id_Actor_Local" 
INNER JOIN "Municipios" C ON A."Id_Municipio" = C."Id_Municipio" 
INNER JOIN "Departamentos" D ON A."Id_Departamento" = D."Id_Departamento" WHERE 1=1
AND "Municipio" LIKE '%Dolores%';