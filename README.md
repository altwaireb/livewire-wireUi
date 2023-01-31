<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo"></a></p>
<p align="center"><a href="https://laravel-livewire.com" target="_blank"><img src="https://user-images.githubusercontent.com/6729097/213883363-2181ab3f-401b-444f-9381-59fc16f4cc0a.svg" width="300" alt="laravel livewire Logo"></a></p>
<p align="center"><a href="https://jetstream.laravel.com/" target="_blank"><img src="https://raw.githubusercontent.com/laravel/jetstream/2.x/art/logo.svg" width="300" alt="laravel livewire Logo"></a></p>





<div id="top"></div>

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#credentials">Credentials</a></li>
  </ol>
</details>


<!-- ABOUT THE PROJECT -->

## About The Project

This project is created to learn and practice livewire; understand why it is created; and explore the power of LIVEWIRE!

This project consists of Livewire table with sorting, search, perPage, and bulk delete functionalities.
It is also integrated with Spatie Laravel permissions and Nprogress.

Support Dark Mode :
<p align="center"><a href="https://user-images.githubusercontent.com/6729097/215651085-279dc2fe-207d-4460-a190-886f1fba9ed5.png" target="_blank"><img src="https://user-images.githubusercontent.com/6729097/215651085-279dc2fe-207d-4460-a190-886f1fba9ed5.png" width="600" alt="dark mode"></a></p>
Left-to-Right Language Support :
<p align="center"><a href="https://user-images.githubusercontent.com/6729097/215652586-53c9c25a-d0fb-4590-89d2-e4b00e777ed4.png" target="_blank"><img src="https://user-images.githubusercontent.com/6729097/215652586-53c9c25a-d0fb-4590-89d2-e4b00e777ed4.png" width="600" alt="dir 'ltr'"></a></p>
Right-to-Left Language Support :
<p align="center"><a href="https://user-images.githubusercontent.com/6729097/215653138-38555282-9f09-4c5a-ab7f-0c7f83da51be.png" target="_blank"><img src="https://user-images.githubusercontent.com/6729097/215653138-38555282-9f09-4c5a-ab7f-0c7f83da51be.png" width="600" alt="dir 'rtl'"></a></p>


<p align="right">(<a href="#top">back to top</a>)</p>

### Built With

* [Livewire](https://laravel-livewire.com/)
* [WireUI](https://livewire-wireui.com/)
* [Laravel Jetstream](https://jetstream.laravel.com/)
* [Windmill Dashboard HTML](https://windmillui.com/dashboard-html)

<p align="right">(<a href="#top">back to top</a>)</p>

<!-- GETTING STARTED -->

## Getting Started

Follow these steps to try this out on your localhost.

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/altwaireb/livewire-wireUi.git
2. Run composer install
   ```sh
   composer install
   ```
3. Create .env
   ```sh
   cp .env.example .env
   ```
4. Generate key
   ```sh
   php artisan key:generate
   ```
5. Run npm install
   ```sh
   npm install
6. Run npm run dev
   ```sh
   npm run dev
   ```
7. Run migration files
   ```sh
   php artisan migrate
   ```
8. Run seeders
   ```sh
   php artisan db:seed
   ```
9. Run on your localhost
   ```sh
   php artisan serve
   ```

<p align="right">(<a href="#top">back to top</a>)</p>


<!-- HOW TO USE -->

## How to use

To create Component inside admin

   ```sh
   php artisan make:livewire admin.model.ModelIndex
   ```

You can use Trait to get all functionality for Sorting and Searching and Pagination.

   ```php

use App\Traits\WithSorting;

class FooIndex extends Component
{
    
    use WithSorting;
    
    ...
   ```

The default sort is the id you can change to another column e.g:

   ```php

use App\Traits\WithSorting;

class FooIndex extends Component
{
    
    use WithSorting;
    
    public function mount()
    {
        $this->sortBy = 'name';
        // same with sort Direction    
        $this->sortDirection = 'asc';          
        // same with Per Page    
        $this->perPage = 25;    
    }
    
    ...
   ```


<p align="right">(<a href="#top">back to top</a>)</p>


<!-- CREDENTIALS EXAMPLES -->

## Credentials

Admin <br/>
username: admin@admin.com <br/>
password: password <br/>


<p align="right">(<a href="#top">back to top</a>)</p>
