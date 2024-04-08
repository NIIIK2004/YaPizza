<?php
?>

<?php include '../php/fragments/head.php'; ?>

<body>
    <section class="landing-section">
        <div class="container">
            <div class="landing_wrapper">
                <div class="landing_left">
                    <span class="landing-text">“Ваш выход из зоны дискомфорта”</span>
                    <h1 class="landing-title">Ароматы, которые говорят громче слов</h1>
                    <p class="landing-description">Творческий и выразительный способ передать идею о том, что вкус и впечатления от еды в конкретном ресторане исключительны, самобытны и приносят удовлетворение.</p>
                    <div class="landing-btns">
                        <a href="#">Заказать</a>
                        <a href="#">Как мы готовим?</a>
                    </div>
                </div>
                <div class="landing_right">
                    <img src="../assets/images/landing/big-pizza.png">
                </div>
            </div>
        </div>
    </section>

    <section class="advantages">
        <div class="container">
            <ul class="advantages_wrapper">
                <li>
                    <h2>10</h2>
                    <span>Видов пицц, придуманные лучшим шеф-поваром</span>
                </li>

                <li>
                    <h2>30</h2>
                    <span>Минут доставка, или с нас бесплатная пиццы</span>
                </li>

                <li>
                    <h2>15%</h2>
                    <span>Скидка постоянным клиентам, и другие акции</span>
                </li>
            </ul>
        </div>
    </section>

    <section class="top_pizza">
        <div class="container">
            <h1 class="title">Самые продаваемые пиццы</h1>
            <ul class="pizza_list">
                <li>
                    <img src="../assets/images/landing/pizza-1.png">
                    <div class="pizza-middle">
                        <div class="pizza-info">
                            <h2>Двойная пепперони</h2>
                            <span>Вес: 600 г</span>
                        </div>
                        <span class="pizza-status">
                            HOT
                        </span>
                    </div>

                    <div class="pizza-bottom">
                        <p class="pizza-cost">620₽</p>
                        <a href="../php/category.php">в корзину</a>
                    </div>
                </li>

                <li>
                    <img src="../assets/images/landing/pizza-2.png">
                    <div class="pizza-middle">
                        <div class="pizza-info">
                            <h2>Баварская мясная</h2>
                            <span>Вес: 450 г</span>
                        </div>
                        <span class="pizza-status">
                            HOT
                        </span>
                    </div>

                    <div class="pizza-bottom">
                        <p class="pizza-cost">790₽</p>
                        <a href="../php/category.php">в корзину</a>
                    </div>
                </li>

                <li>
                    <img src="../assets/images/landing/pizza-3.png">
                    <div class="pizza-middle">
                        <div class="pizza-info">
                            <h2>Цыпленок Карри</h2>
                            <span>Вес: 300 г</span>
                        </div>
                        <span class="pizza-status">
                            HOT
                        </span>
                    </div>

                    <div class="pizza-bottom">
                        <p class="pizza-cost">620₽</p>
                        <a href="../php/category.php">в корзину</a>
                    </div>
                </li>

                <li>
                    <img src="../assets/images/landing/pizza-4.png">
                    <div class="pizza-middle">
                        <div class="pizza-info">
                            <h2>Цыпленок BBQ</h2>
                            <span>Вес: 800 г</span>
                        </div>
                        <span class="pizza-status">
                            HOT
                        </span>
                    </div>

                    <div class="pizza-bottom">
                        <p class="pizza-cost">333₽</p>
                        <a href="../php/category.php">в корзину</a>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    <section class="workPeople">
        <div class="container">
            <h1 class="title">3 лучших работников</h1>
            <ul class="workPeople_wrapper">
                <li>
                    <img src="../assets/images/landing/work-1.png">
                    <h2 class="workPeople-name">Никита Смирнов</h2>
                    <span class="workPeople-work">Повар - Владелец</span>
                </li>

                <li>
                    <img src="../assets/images/landing/work-2.png">
                    <h2 class="workPeople-name">Алина Соколова</h2>
                    <span class="workPeople-work">Глаза и Уши</span>
                </li>

                <li>
                    <img src="../assets/images/landing/work-3.png">
                    <h2 class="workPeople-name">Никита Смирнов</h2>
                    <span class="workPeople-work">Повар - Владелец</span>
                </li>
            </ul>
        </div>
    </section>

    <section class="reviews">
        <div class="container">
            <h1 class="title">~ Немного важных цитат</h1>
            <ul class="reviews_list">
                <li>
                    <img src="../assets/images/landing/ковычки.svg">
                    <h2 class="reviews_title">“Любовь к вкусу рождается, только из-за дизайна, этого вкуса, вряд-ли попробуйте продукт который не красиво выглядит!”</h2>
                    <div class="reviews_author">
                        <span>Арсэн Пешко</span>
                        <span>Продукт-дизайнер</span>
                    </div>
                </li>

                <li>
                    <img src="../assets/images/landing/ковычки.svg">
                    <h2 class="reviews_title">“Любовь к вкусу рождается, только из-за дизайна, этого вкуса, вряд-ли попробуйте продукт который не красиво выглядит!”</h2>
                    <div class="reviews_author">
                        <span>Арсэн Пешко</span>
                        <span>Продукт-дизайнер</span>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    <section class="contacts">
        <div class="container">
            <h1 class="title">Подпишитесь на наши новости</h1>
            <div class="contacts_wrapper">
                <input type="email" class="contacts_input" placeholder="Введите свою почту">
                <button type="submit" class="contacts_btn">Подписаться</button>
            </div>
        </div>
    </section>

    <section style="margin: 100px 0;"></section>
</body>

<?php include '../php/fragments/footer.php'; ?>
