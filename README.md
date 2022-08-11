
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://blockstairs.com/wp-content/uploads/2022/07/icon_positivo_500x500.png" width="300"></a></p>
<h1 align="center">Blockstairs Api</h1>



## Blockstairs Api Teste

### Modelo lógico 

![relação](https://user-images.githubusercontent.com/31674845/184058872-0710b70d-2aff-449b-9c30-1f5a8b01ffbb.jpeg)


<p>Aqui vai umas dicas para rodar o teste</p>

- Conferir a versão do php, o teste esta na Versão "^9.0".
- Fazer o clone do repositório.
- Rodar os comandos abaixo:
  ```bash
    cd blockstairs-api
    composer install      
  ```
 - Após isso basta publicar o provider e gerar os arquivos do Swagger.
     ```bash
       php artisan vendor:publish
        #Provider: L5Swagger\L5SwaggerServiceProvider ........... 5
       php artisan l5-swagger:generate
      ```
 
  
  
- Use o .env.example pois existem alguns parâmetros a ser mantidos.
    - Configure o banco de dados da sua escolha e depois de tudo certo rode o comando abaixo.    
   ```bash
    php artisan migrate --seed 
    
  ```
  
### Documentação e arquivo do insomnia.

- O arquivo com todos os endpoints para importar no insomnia <a href="https://github.com/afermanx/blockstairs-api/tree/main/doc">Blockstairsapi_2022-08-10.json</a>

- O link da api, e a Documentação com swagger <a href="https://blockstairs.villasis.com.br/">Blockstairs-api</a>




