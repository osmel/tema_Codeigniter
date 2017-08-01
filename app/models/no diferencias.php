
1 122 chicanol (no sale)
1 123 copachisa

1 141 app transporte  69.5 * 82.79=5753.905

2 129 onboarding (375)
3 148 otros


SELECT id_proyecto, sum(horas) hrs, id_usuario  
FROM  inven_registro_user_proy
WHERE id_proyecto =141
group by id_usuario


