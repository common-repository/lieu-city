document.addEventListener('DOMContentLoaded', function (e) {
    const resultsContainer = document.querySelector(".results__container");
    const filtersContainer = document.querySelector(".filters__container");
//Test
    /***TEST */
    class Exhibitions {
        shuffleElement;
        shuffleContainer;
        searchInput;
        searchClear;
        orderSelect;
        checkboxFilters = [];

        constructor() {
            this.shuffleContainer = document.querySelector("#shuffle__container");
            this.searchInput = document.querySelector("#exhibition__search__input");
            this.searchClear = document.querySelector("#search__input__clear");
            this.orderSelect = jQuery("#order_by_select").niceSelect();
            this.checkboxFilters = Array.from(
                    document.querySelectorAll(".check__filter__exh")
                    );

            //Istanziamo shuffle
            this.shuffleElement = new Shuffle(this.shuffleContainer, {
                itemSelector: ".exhibition__card__container",
            });

            //Attacchiamo gli event listeners
            this.searchInput.addEventListener(
                    "keyup",
                    this._handleFiltering.bind(this)
                    );

            this.checkboxFilters.forEach((check) => {
                check.addEventListener("change", this._handleFiltering.bind(this));
            });

            this.searchClear.addEventListener("click", this._handleClear.bind(this));
            this.orderSelect.on("change", this._handleSorting.bind(this));
        }

        _handleClear(e) {
            this.searchInput.value = "";
            this._handleFiltering(e);
        }

        //Funzione per gestire il filtraggio tramite checkbox
        _handleFiltering(e) {
            const searchedValue = this.searchInput.value.trim().toLowerCase();
            const checkedValues = this.checkboxFilters
                    .filter((check) => check.checked)
                    .map((check) => check.value);

            if (searchedValue.length === 0 && checkedValues.length === 0) {
                this.shuffleElement.filter(Shuffle.ALL_ITEMS);
                return;
            }

            this.shuffleElement.filter((element, shuffle) => {
                const dataGroups = element.dataset.groups.split(",");
                const titleElement = element.querySelector(".exhibition__title");
                const titleText = titleElement.textContent.toLowerCase().trim();
                const titleFound = titleText.includes(searchedValue);

                //Checkbox
                let validElementType = true;
                if (checkedValues.length) {
                    validElementType = dataGroups.some((el) => checkedValues.includes(el));
                }
                return titleFound && validElementType;
            });
        }

        //Funzione per gestire l'ordinamento tramite select
        _handleSorting(e) {
            const selectedIndex = e.target.options.selectedIndex;
            const selectedOption = e.target.options[selectedIndex];
            const orderType = selectedOption.dataset.type;
            const orderMode = selectedOption.dataset.mode;
            let options;
            if (orderType === "created") {
                options = {
                    reverse: orderMode === "desc" ? true : false,
                    by: this._sortByDate,
                };
            } else if (orderType === "title") {
                options = {
                    by: this._sortByTitle,
                    reverse: orderMode === "desc" ? true : false,
                };
            } else {
                options = {};
            }

            this.shuffleElement.sort(options);
        }

        _sortByDate(element) {
            return element.dataset.created;
        }

        _sortByTitle(element) {
            return element.dataset.title.toLowerCase();
        }
    }

    function render(props) {
        return (tok, i) => {
            return i % 2 ? props[tok] : tok;
        };
    }

    function randstr(prefix)
    {
        return Math.random().toString(36).replace('0.', prefix || '');
    }
    
    function renderExhibition(exhibitionsArray) {
        const shuffleContainer = document.querySelector("#shuffle__container");
        const exhibitionCardTemplate = document
                .querySelector("#exhibition__card__template")
                .textContent.split(/\$\{(.+?)\}/g);
        return Promise.all(
                exhibitionsArray.map((exhibition) => {
                    return new Promise(function (resolve, reject) {
                        const items = [
                            {
                                exhibition_groups: "street-art",
                                exhibition_date: exhibition.date_from,
                                exhibition_title: exhibition.name,
                                exhibition_id: exhibition.id,
                                exhibition_type: "street-art",
                                exhibition_height : "450px",
                                exhibition_width : "600px"
                            },
                        ];
                        shuffleContainer.insertAdjacentHTML(
                                "beforeend",
                                items.map((item) => {
                                    return exhibitionCardTemplate.map(render(item)).join("");
                                })
                                );
                        const exbImage = document.querySelector(
                                `#exhibition__image__${exhibition.id}`
                                );
                        exbImage.src = exhibition.cover_img;
                        exbImage.addEventListener("load", function (e) {
                            resolve("Image loaded");
                        });
                    });
                })
                );
    }
    function getExhibitions() {
        const endPoint = "https://api.lieu.city/v1/login/wordpress/exhibitions";
        return fetch(endPoint, {
            headers : {
                "Authorization" : `Bearer ${lieu_options.token}`,
            },
            method : "GET"
        }).then((res) => res.json()).then((res) => {
            return res;
        })
        .catch((err) => console.error("Failed to get exhibitions"));
    }

    function setAnonExhibitions(id) {
        //console.log("anonimizza");
        const endPoint = `https://api.lieu.city/v1/login/wordpress/exhibitions/${id}`;
        return fetch(endPoint, {
            headers : {
                "Authorization" : `Bearer ${lieu_options.token}`,
                "Accept" : `application/json`,
                "Content-Type" : `application/json`
            },
            method : "PATCH",
            body : JSON.stringify({
                "enable_anon_access": true
            }),
            
        }).catch((err) => console.error("Failed to get exhibitions"));
    }

    function setExportExhibitions(id) {
        //console.log("esporta");
        const endPoint = `https://api.lieu.city/v1/login/wordpress/exhibitions/${id}/exports/published`;
        return fetch(endPoint, {
            headers : {
                "Authorization" : `Bearer ${lieu_options.token}`,
                "Accept" : `application/json`,
                "Content-Type" : `application/json`
            },
            method : "POST"
            
        }).then((res) => res.json()).then((res) => {
            return res;
        })
        .catch((err) => console.error("Failed to get exhibitions"));
    }

    (async () => {
    
        const exhibitions = await getExhibitions();
        await renderExhibition(exhibitions);
        const exh = new Exhibitions();


        
        //Event listeners
        const flipBtns = document.querySelectorAll(".btn-flip-button");
        flipBtns.forEach((btn) =>
            btn.addEventListener("click", function (e) {
                btn.closest(".exhibition__card__wrapper").classList.toggle("exhibition__card__flip");
                const id_lieu = this.dataset.exhibitionid;
                setAnonExhibitions(id_lieu);
            })
        );

        const flipBackBtns = document.querySelectorAll(".flip__back__button");
        flipBackBtns.forEach((btn) =>
            btn.addEventListener("click", function (e) {
                btn.closest(".exhibition__card__wrapper").classList.toggle("exhibition__card__flip");
            })
        );

        const copyTextBtns = document.querySelectorAll(".btn__copy__link");
        copyTextBtns.forEach((btn) => {
            btn.addEventListener("click", function (e) {
                const codeContainer = this.closest(".code__container");
                const codeToCopy =
                        codeContainer.querySelector(".code__copyable").textContent;
                navigator.clipboard.writeText(codeToCopy);
                this.classList.add("active");
                setTimeout(() => {
                    this.classList.remove("active");
                }, 2000);
            });
        });
        
        const dimensionSliders = document.querySelectorAll(".dimension_slider"); 
        dimensionSliders.forEach(slider =>  slider.addEventListener('input',function(){
            const target = document.querySelector(this.dataset.target);
            let dimension = "";
            switch(this.type){
                case 'range':
                    dimension = `${this.value}%`
                    break;
                case 'number':
                    dimension = `${Math.abs(this.value)}px`
                    break;
            }
            target.innerHTML = dimension;
        }))
    })();



})

