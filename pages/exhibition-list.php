<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lieu Plugin - Exhibitions</title>        
</head>

<body>
    <!--Wrapper start-->
    <div class="grid__wrapper" id="users">
        
            <section class="grid__navbar" >
                <img class="lieu-logo" src="<?php echo plugins_url(('/../assets/svg/lieu_cropped_logo.svg'), __FILE__) ?>">
                <form method="post">
                    <button class="lieu__button" name="lieu_backend_button" style="position:absolute; top: 2%; left: 2%;" type="button" onclick="window.open('https://backend.lieu.city/signin.php')" >Gestisci mostre</button>
                    <button class="lieu__button" name="lieu_logout_button" style="position:absolute; top: 2%; right: 2%;" ><i class="fa-solid fa-right-from-bracket"></i></button>        
                </form>
            </section>
        

        <section class="filters__container collapse" id="filters__collapse__section">
            <h5 class="filters__container__title grid-col-span-2">Filtra esibizioni</h5>
            <div class="exhibition__filter">
                <h5 class="filter__title grid-col-span-2">Filter type 1</h5>
                <div class="filters__item">
                    <div class="checkbox__container">
                        <input value="street-art" id="check1" type="checkbox" class="check__filter__exh">
                        <label for="check1">Street art</label>
                    </div>
                    <span class="filter__badge">
                        0
                    </span>
                </div>
                <div class="filters__item">
                    <div class="checkbox__container">
                        <input value="painting" id="check2" type="checkbox" class="check__filter__exh">
                        <label for="check2">Painting</label>
                    </div>
                    <span class="filter__badge">
                        0
                    </span>
                </div>
            </div>
            <div class="exhibition__filter">
                <h5 class="filter__title grid-col-span-2">Filter type 2</h5>
                <div class="filters__item">
                    <div class="checkbox__container">
                        <input value="photography" id="check3" type="checkbox" class="check__filter__exh">
                        <label for="check3">Photography</label>
                    </div>
                    <span class="filter__badge">
                        0
                    </span>
                </div>
                <div class="filters__item">
                    <div class="checkbox__container">
                        <input value="video-art" id="check4" type="checkbox" class="check__filter__exh">
                        <label for="check4">Video art</label>
                    </div>
                    <span class="filter__badge">
                        0
                    </span>
                </div>
            </div>
        </section>

        <!--Header searchbar-->
        <section class="header__container">
            <div class="header__search searchbar__header__item">
                <div class="search__bar__container">
                    <div class="search__icon"></div>
                    <div class="exh__search__input__container">
                        <input type="text" placeholder="Cerca..." id="exhibition__search__input">
                    </div>
                    <span id="search__input__clear" class="search__clear"></span>
                </div>
            </div>

            <div class="header__buttons searchbar__header__item">
                <button class="lieu__button d-none" id="btn__toggle__filter" data-bs-toggle="collapse"
                    href="#filters__collapse__section" role="button" aria-expanded="false"
                    aria-controls="filters__collapse__section">
                    <i class="fa-solid fa-filter"></i>
                </button>
                <!--
                <div class="switch__view">
                    <input type="radio" id="radio-one" name="switch-one" value="yes" checked />
                    <label for="radio-one">
                        <i class="fa-solid fa-grip"></i>
                    </label>
                    <input type="radio" id="radio-two" name="switch-one" value="no" />
                    <label for="radio-two">

                        <i class="fa-solid fa-list"></i>
                    </label>
                </div>-->
            </div>

            <div class="header__order searchbar__header__item">
                <label for="order_by_select">Ordina</label>
                <select id="order_by_select">
                    <option data-type="title" data-mode="asc" value="0">Alfabetico A-Z</option>
                    <option data-type="title" data-mode="desc" value="1">Alfabetico Z-A</option>
                    <option data-type="created" data-mode="asc" value="2">Data Asc</option>
                    <option data-type="created" data-mode="desc" value="3">Data Desc</option>
                </select>
            </div>

        </section>
        <!--Header searchbar-->



        <section class="results__container" id="shuffle__container">

        </section>
    </div>
    <!--Wrapper ends-->




    <script id="exhibition__card__template" type="text/x-custom-template">
            <div data-exhibitionid="${exhibition_id}" id="exhibition_card_${exhibition_id}" class="exhibition__card__container" data-groups='${exhibition_groups}' 
                data-created="${exhibition_date}" data-title="${exhibition_title}">
                <div class="exhibition__card">
                    <div class="exhibition__card__wrapper">
                        <div class="exhibition__card__front">
                            <div class="front__card__header">
                                <img id="exhibition__image__${exhibition_id}" src=""  />
                            </div>
                            <div class="front__card__body">
                                <span class="tag tag-teal">${exhibition_type}</span>
                                <h5 class="exhibition__title">
                                    ${exhibition_title}
                                </h5>
                                <p>
                                    ${exhibition_date}
                                </p>
                                <div class="front__card__buttons">
                                    <button data-exhibitionid="${exhibition_id}" class="lieu__button btn-flip-button">Genera Link</button>
                                </div>
                            </div>
                        </div>
                        <div class="exhibition__card__back">
                                <div class="back__card__body">
                                    <div class="back__buttons__container">  
                                        <button class="lieu__button lieu__button-circle flip__back__button">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <h5 class="back__card__body__title">
                                        Copia il seguente ShortCode e includilo nel tuo sito web!
                                    </h5>
                                <div class="code__container">
                                    <div class="code__container__buttons">
                                        <button class="btn__copy__link">
                                            <i class="fa-solid fa-copy" title="Copia codice"></i>
                                        </button>
                                    </div>
                                    <pre class="code__copyable" id="code">[lieucity]<span>${exhibition_id}</span>;<span id="short_code_height_${exhibition_id}">${exhibition_height}</span>;<span id="short_code_width_${exhibition_id}">${exhibition_width}</span>[/lieucity]</pre>
                                </div>
                                
                                <div class="exhibition__card__back__body">
                                    <h6 class="exhibition__card__back__body__title">Dimensioni riquadro</h6>
                                        
                                    <div class="short_code_dimension_container">
                                       <div class="short_code_dimension_item" >
                                           <label for="altezza_input_${exhibition_id}" >Altezza px</label>
                                           <input data-target="#short_code_height_${exhibition_id}" data-exhibitionid="${exhibition_id}" class="dimension_slider" type="number" step="1" id="altezza_input_${exhibition_id}" value="450">
                                       </div>
                                        <div class="short_code_dimension_item" >
                                           <label for="altezza_slider_${exhibition_id}" >Altezza %</label>
                                           <input data-target="#short_code_height_${exhibition_id}" data-exhibitionid="${exhibition_id}" class="dimension_slider" type="range"  value="100" min="0" max="100" step="1" id="altezza_slider_${exhibition_id}">
                                       </div>
                                    </div>
                                    
                                    <hr>

                                    <div class="short_code_dimension_container">
                                        <div class="short_code_dimension_item" >
                                            <label for="larghezza_input_${exhibition_id}" >Larghezza px</label>
                                            <input data-target="#short_code_width_${exhibition_id}" data-exhibitionid="${exhibition_id}" class="dimension_slider" type="number" step="1" id="larghezza_input_${exhibition_id}" value="600">
                                        </div>
                                        <div class="short_code_dimension_item">
                                            <label for="larghezza_slider_${exhibition_id}" >Larghezza %</label>
                                            <input data-target="#short_code_width_${exhibition_id}" data-exhibitionid="${exhibition_id}" class="dimension_slider" type="range" value="100" min="0" max="100" step="1" id="larghezza_slider_${exhibition_id}">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </script>

</body>

</html>