# WordPress SEO REST

Disponibiliza na REST API os campos configurados através do plugin wordpress-seo (Yoast).

Funciona tanto para os post_types, quanto para as taxonomias.

* meta-title
* meta-description
* facebook
* twitter

**Exemplo de retorno - Posts**

```javascript
"seo": {
  "open_graph": {
	"title": "Olá, mundo! - WordPress DEV",
	"description": "Bem-vindo ao WordPress. Esse é o seu primeiro post. Edite-o ou exclua-o, e então comece a escrever!",
	"type": "article",
	"locale": "pt_BR",
	"site_name": "WordPress DEV",
	"image": false,
	"modified_time": "2018-06-28T16:01:47-03:00",
	"published_time": "2018-06-28T16:01:47-03:00"
  },
  "twitter": {
	"title": "Olá, mundo! - WordPress DEV",
	"description": "Bem-vindo ao WordPress. Esse é o seu primeiro post. Edite-o ou exclua-o, e então comece a escrever!",
	"type": "summary_large_image",
	"image": false
  },
  "meta": {
	"title": "Olá, mundo! - WordPress DEV",
	"description": "Bem-vindo ao WordPress. Esse é o seu primeiro post. Edite-o ou exclua-o, e então comece a escrever!"
  }
},
```
**Exemplo de retorno - Taxonomias**

```javascript
"seo": {
  "open_graph": {
	"title": "Título Categoria 1 - Facebook",
	"description": "Descrição Categoria 1 - Facebook",
	"type": "object",
	"image": "http://localhost/wordpress-dev/wp-content/uploads/2018/07/sample.jpeg"
  },
  "twitter": {
	"title": "Categoria 1 - Twitter",
	"description": "Categoria 1 - Twitter",
	"type": "summary_large_image",
	"image": "http://localhost/wordpress-dev/wp-content/uploads/2018/07/sample.jpg"
  },
  "meta": {
	"title": "Categoria 1 title SEO",
	"description": "Lorem ipsum categoria 1"
  }
},
```
