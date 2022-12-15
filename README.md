# pt07

Aquesta practica te la finalitat de provar el concepte "AJAX", el qual permet fer pagines dinamiques i actualitzar el seu contingut sense haver de carregar altres pagines. Aixo es aconsegeix realitzant peticions mitjançant JavaScript i mostrant la resposta en la pagina ja carregada.

# Posada en marxa
## Opcio 1 (fácil)
Si disposem de docker i docker-compose, podem posar en marxa amb les dependencies necessaries "ja instal·lades" en dos contenidors, un pel php i un altre per la base de dades, amb la seguent comanda.
```docker-compose up -d --build``` (la primera vegada necessita --build)
Accedim al navegador al port 8023 (http://localhost:8023).

## Opcio 2
### Configurar les variables d'entorn
Primer de tot s'ha de configurar al fitxer env.php la ruta del directori on es troba la web. Si la ruta del fitxer es "servidor/web/uf2/pt04" al fitxer env haig de posar 
```$baseUrl = "/servidor/UF3/pt06/";``` . Molt important que tingui barra al principi i al final. En cas de trobar-se en l'arrel nomes posarem una barra ```$baseUrl = "/";```

Per ultim afegirem les credencials de la base de dades per a un funcionament basic.
Aquestes credencials s'han de configurar en aquestes variables

```php
$mysqlUser = "usuari";
$mysqlPassword = "contrasenya";
$mysqlHost = "mysql.local";
$mysqlDB = "p04";
```

### Crear base de dades
Executarem el fitxer [sql](pt06_marc_peral.sql) en mysql per crear la base de dades amb les taules necessaries.

# Parts del projecte
