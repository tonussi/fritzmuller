# Projeto Fritz Müller

Projeto educacional para auxiliar Maria Cristina P. T. https://fritzmuller.org/

<img src="fritzmuller.jpg" height="250px"></img>

## Características

- Laravel Framework + PHP 7.2.
- Vue + VueRouter + Vuex + VueI18n + Vuetify.
- Login, registro, password reset, e JWT.

## Work in Progress

- Taxonomia dos Animais e Plantas.
- Listagens de imagens Splink e Arkive.

## Instalação

Bastante simples de instalar.

- `composer create-project --prefer-dist tonussi/fritzmuller`.
- Editar o `.env` com suas preferências de banco de dados.
- (Depois de instalar via git, execute o seguinte `php artisan key:generate` e `php artisan jwt:secret`).
- `php artisan migrate`.
- `composer config -g repos.packagist composer https://packagist.com.br`.
- `composer install`.
- `yarn` (Instale [Yarn](https://yarnpkg.com/en/docs/install) caso você não tenha ele.).
- `php artisan serve` você sobe um servidor para testar o app localmente.
- `yarn watch` você pode ficar compilando as mudanças do código em Vue e Javascript e SASS em tempo real.

## Desenvolvimento

```bash
# build and watch
yarn run watch-poll

# serve with hot reloading
yarn run hot
```

## Produção

Lembrar de executar esse comando para sintetizar o javascript compilado e final.

```bash
yarn run production
```

## i18n

A internacionalização desse app/site foi feita usando os recursos de um plugin para Laravel. Esse plugin ajuda a converter e empacotar todas as traduções para um único .json que é carregado por inteiro na página do usuário para poder oferecer tradução dos componentes padrão do site, em tempo real sem precisar recarregar a página. Existem muitos meios de fazer essa mesma ideia, como por exemplo fazer requisições assíncronas de apenas a tradução desejada e atualizar todos os componentes Vue() contidos no app/site.

O plugin que eu utilizo para converter o que está em `resources/lang` em `resources/assets/js/vue-i18n-locales.generated.js`, está integrado com esse app e pode ser encontrado aqui https://github.com/martinlindhe/laravel-vue-i18n-generator.

Para acionar esse plugin você precisa ter as traduções feitas em arquivos `.php`, em `resources/lang` e depois utilizar um comando `php artisan vue-i18n:generate`. A seguir, exemplos do conteúdo de tradução contido nos arquivos `resources/lang/en-US/admin.php` e `resources/lang/pt-BR/admin.php`.

```php
<?php
return [
    'manage' => 'Manage this',
    'article_title' => "Your Articles",
    'article_description' => "Manage, Edit, Your Articles",
    'running_title' => "Your Running Activities",
    'running_description' => "Manage, Edit, Running Activities",
    'animal_title' => "Fauna: Animals",
    'animal_description' => "Manage, Edit, Fauna: Animals and its Related Taxas",
    'plant_title' => "Flora: Plants",
    'plant_description' => "Manage, Edit, Flora: Plants and its Related Taxas",
    'project_description' => "Manage, or edit running projects",
    'member_description' => "Manage, or edit project members",
    'project_title' => "Current Projects",
    'member_title' => "Project's Members",
    'articles_session' => 'Article\'s Session',
    'activities_session' => 'Merchandise\'s Session',
    'species_session' => 'Species\'s Session',
    'projects_session' => 'Projects\'s Session',
    'members_session' => 'Colaborator\'s Session',
    'taxonomy_session' => 'Taxonomy\'s Session',
];

<?php
return [
    'manage' => 'Administrar isso',
    'article_title' => "Seus artigos",
    'article_description' => "Administrar, Editar, os seus Artigos",
    'running_title' => "As Atividades Rolando",
    'running_description' => "Administrar, Editar, as suas Atividades Rolando",
    'animal_title' => "Fauna: Animais",
    'animal_description' => "Administrar, Editar, Fauna: Animais e seus Taxonomias",
    'plant_title' => "Flora: Plantas",
    'plant_description' => "Administrar, Editar, Flora: Plantas e suas Taxonomias",
    'project_description' => "Administrar, ou editar os projetos atuais",
    'member_description' => "Administrar, ou editr os membros de projetos",
    'project_title' => "Atuais Projetos",
    'member_title' => "Membros dos Projetos",
    'articles_session' => 'Sessão dos Artigos',
    'activities_session' => 'Sessão da Publicidade',
    'species_session' => 'Sessão das Espécies',
    'projects_session' => 'Sessão dos Projetos',
    'members_session' => 'Sessão dos Membros',
    'taxonomy_session' => 'Sessão das Taxonomias',
];
```

Esse plugin, explicado acima, é justamente focado em integrar a internacionalização com o Vuei18n que eu explicarei em seguida. No caso a parte do Vuei18n desse aplicativo aqui pode ser encontrado em `resources/assets/js/plugins/i18n.js`, isso integra as traduções com o app em Vue.

``` js
import Vue from 'vue';
import VueI18n from 'vue-i18n';
import Locales from '../vue-i18n-locales.generated.js'; // Pacote com todas as traduções.

Vue.use(VueI18n);

const i18n = new VueI18n({
  locale: localStorage.getItem('locale'),
  messages: Locales
});

export default i18n;
```

Esse import aqui `Locales from '../vue-i18n-locales.generated.js';`, se trata do empacotamento feito pelo plugin `laravel-vue-i18n-generator` citado acima.

Essa exportação `i18n`, pode ser integrada no app da seguinte maneira:

```js
import Vue from 'vue'
import store from './store'
import router from './router'
import i18n from './plugins/i18n'
import App from './components/common/App'

import './plugins'
import './components/common'

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
```

Esse código pode ser encontrado em `resources/assets/js/app.js`.

Para utilizar o sistema de tradução basta fazer o seguinte dentro de um template vue (arquivos .vue):

```html
<p>{{ $t('message.hello') }}</p>
```

# Conversão do formato da moeda

O código que formata a moeda pode ser encontrado em `resources/assets/js/plugins/filters.js`. Foi feito utilizando o próprio recurso nativo do Javascript, porém esse recurso foi integrado à aplicação em Vuejs através da criação de um filtro, ou seja, todo mundo que utilizar esse filtro, ou seja todos os preços em número real (strings não funcionam) vão ser convertidos.

> Alguns componentes do Vuetify (biblioteca e framework de componentes prontos em Vue) não se adequam bem aos filtros e a conversão em tempo real, sendo preciso mexer no componente para que ele atualize a conversão.

O Código seguinte expressa o filtro Vue para formatar valores. Foi utilizado `Intl.NumberFormat`, Intl é uma class própria do Javascript, e NumberFormat é outra class contida dentro de Intl (abreviação de Internacionalização), usada para formatar números. Essa classe NumberFormat você passa argumentos para construir um objeto que representa que tipo de formatação você deseja fazer. Os argumentos abaixo são: locale (para o NumberFormat poder utilizar digitos compatíveis com a linguagem, depois vem um parâmetro tipo dicionário: style (currency), currency (aqui é acessado o LocalStorage do browser do usuário para saber qual tipo de currency ele configurou), e depois minimumFractionDigits (zero). Minimum Fraction Digits quer dizer o número mínimo de digitos fracionários para utilizar, e foi configurado como 2. A explicação do número 2 vem a seguir.

> **minimumFractionDigits**: "A quantidade mínima de dígitos fracionados para utilizar. É possível usar valores de 0 a 20; o padrão para formatos de números simples e percentuais é 0; o padrão para formatos monetários é a menor unidade de dígitos fornecidos pela lista de códigos de moedas ISO 4217 (2 se a lista não fornecer a informação)." (fonte: https://www.google.com/search?client=ubuntu&channel=fs&q=minimumFractionDigits&ie=utf-8&oe=utf-8).

O código do filtro que pode ser usado nos preços vem a seguir.

```js
Vue.filter('currencyi18n', function (value) {
 if (typeof value !== "number") {
  return value;
 }

 var locale = localStorage.getItem('locale'); // tenta pegar o local configurado pelo usuário
 if (locale === undefined) { // caso não exista ele auto-configura como pt-BR
   locale = 'pt-BR';
 }

 var formatter = new Intl.NumberFormat(locale, {
  style: 'currency',
  currency: localStorage.getItem('currency'),
  minimumFractionDigits: 2
 });

 return formatter.format(value);
});
```

Esse filtro pode ser usado em qualquer lugar do APP, mas em arquivos .vue. Contidos em `resources/assets/js/components`.

# Novas Traduções

É preciso alguns poucos passos:

1. Adicionar em `resources/lang` uma pasta com o codígo do local, ou seja pt-BR, en-US, etc... Formatos como pt_BR, en_US, também são aceitos.
2. Depois é preciso modificar um plugin localizado em `resources/assets/js/plugins/localemanager.js`.

O LocaleManager.js contém o seguinte conteúdo:

```js
var localeCodes = [
  {
    "code": 'en-US',
    "name": 'English (United States)'
  },
  {
    "code": 'pt-BR',
    "name": 'Português (Brasileiro)'
  }
]

var getSystemLocale = function() {
  var aux = localStorage.getItem('locale');

  if (aux === null) {
    localStorage.setItem('locale', 'pt-BR');
    return 'pt-BR';
  }

  return aux;
}

var setSystemLocale = function(v) {
  return localStorage.setItem('locale', v);
}

const localemanage = {
  "localeCodes": localeCodes,
  "getSystemLocale": getSystemLocale,
  "setSystemLocale": setSystemLocale
}

export default localemanage;
```

É preciso apenas adicionar as metainformações de cada tradução feita. Existe a possibilidade de essas metainformações estarem contidas no pacote de traduções. O pacote de traduções se encotra em `resources/assets/js/vue-i18n-locales.generated.js`. Ele é parecido com o seguinte:

```json
export default {
    "en-US": {
      // ...
    },
    "pt-BR": {
      // ...
    }
}
```

# Traduzindo datas

Para traduzir datas é bastante simples. Foi feito também um filtro para ser usado em qualquer data do app, ou seja, qualquer lugar onde é desejado formatar datas de maneira automática e internacionalizada. Como é feita a internacionalização aqui nesse caso? O formato da data que vem do banco de dados é sempre a mesma YYYY-MM-DD, sempre assim, e é assim que é gravada no banco de dados. Portanto, o filtro abaixo recebe uma valor (`value`), esse valor é para ser entendido como `YYYY-MM-DD`, e dependendo do local que o usuário escolheu na interface visual do app esse filtro irá formatar a dada na linguagem escolhida. LL é um código de como a data irá aparecer na síntese, LL formata da seguinte maneira _i.e_. `November 20, 2018`, ou seja, `<Mês por extenso> <dia em número>, <ano em número>`.

```js
Vue.filter('datei18n', function (value) {
 if (!value) return '';
 /* Attention YYYY-MM-DD is not a locale! This is the database generic format! */
 return moment(String(value), 'YYYY-MM-DD').locale(localStorage.getItem('locale')).format('LL');
});
```

Esse filtro pode ser usado em qualquer lugar do APP, mas em arquivos .vue. Contidos em `resources/assets/js/components`.

# Conclusões sobre a Internacionalização

Vimos que é bastante fácil de integrar a internacionalização automática no aplicativo Vue, basta colocar as traduções em `resources/lang` e depois complementar metainformação em localemanager.js (`resources/assets/js/plugins/localemanager.js`). No app, eu preferi por enquanto deixar assim para não misturar traduções com as metainformações, porém poderia ser misturado e então ter sido feito de outra maneira em código, buscando pelo campo responsável pela metainformação nas traduções geradas pelo plugin, que foi explicado no início.

```js
var localeCodes = [
  {
    "code": 'en-US',
    "name": 'English (United States)'
  },
  {
    "code": 'pt-BR',
    "name": 'Português (Brasileiro)'
  }
]
```
