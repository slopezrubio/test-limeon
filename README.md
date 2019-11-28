<p>To get this repository working you will need to install the following packages manager: <p>
<ul>
  <li><a href="https://nodejs.org/es/download/package-manager/">NPM</a></li>
  <li><a href="https://getcomposer.org/">Composer</a></li>
  <li><a href="https://yarnpkg.com/en/docs/install#debian-stable">YARN</a></li>
</ul>

<p>Follow the next steps:</p>

<ul>
  <li>
    <p>Install all the dependencies needed for each package manager:</p>
    <code>
      npm i
    </code>
    <br/>
    <code>
      composer install
    </code>
    <br/>
    <code>
      yarn add @symfony/webpack-encore --dev
    </code>
  </li>
  <li>
    <p>Inside the root directory of your project create an <code>.env</code> with the URL of your database following the pattern above:</p>
    <code>postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=11</code>
  </li>
  <li>
    <p>Migrate the current version of the database:</p>
    <code> php bin/console doctrine:migrations:migrate 20191028120536</code>
    <p>So far, you should have five tables created: <code>apartments, buildings, rooms, actions and migrations</code>
  </li>
  <li>
    <p>Seed some data to the database as to test the application out by typing:</p>
    <code>php bin/console doctrine:fixtures:load</code>
    <p>There should create 17 entries in the <code>room</code> table, 10 in <code>buildings</code> and 9 in <code>apartments</code> 
  </li>
  <li>
    <p>Run Webpack Encore to generate the <code>.css</code> and <code>.js</code> bundles:</p>
    <code>npm run encore:start</code>
  </li>
</ul>
