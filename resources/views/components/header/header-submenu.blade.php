{{-- Mega submenu (zatím statické HTML, napojení na admin later) --}}
<div id="submenu-level2" class="dropdown-menu-custom">
    <div class="dropdown-menu-bg">
        <div class="container-fw mx-0">
            <div class="submenu-content">
                <!-- View 1: Základní rozdělení -->
                <div id="view-v1" class="submenu-view">
                    <div class="category-header d-flex text-dark-grey justify-content-center">Základní rozdělení</div>
                    <div class="grid-5 ms-70">
                        <div>
                            <a href="/poster" class="text-decoration-none no-underline">
                                <div class="product-category">
                                    <div class="product-title text-dark-grey">Poster</div>
                                    <div class="product-subtitle text-dark-grey">plakátové</div>
                                    <div class="product-image-container">
                                        <div class="product-image-bg">
                                            <div class="product-label text-dark-grey">citylighty</div>
                                            <img src="{{ asset('assets/images/Poster_group.webp') }}" alt="Poster" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#" class="text-decoration-none no-underline">
                                <div class="product-category">
                                    <div class="product-title text-dark-grey">Scroll</div>
                                    <div class="product-subtitle text-dark-grey">rolovací</div>
                                    <div class="product-image-container">
                                        <div class="product-image-bg">
                                            <div class="product-label text-dark-grey">citylighty</div>
                                            <img src="{{ asset('assets/images/Scroll_group-green.webp') }}" alt="Scroll" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#" class="text-decoration-none no-underline">
                                <div class="product-category">
                                    <div class="product-title text-dark-grey">Smart</div>
                                    <div class="product-subtitle text-dark-grey">monitor</div>
                                    <div class="product-image-container">
                                        <div class="product-image-bg">
                                            <div class="product-label text-dark-grey">citylighty</div>
                                            <img src="{{ asset('assets/images/Smart_group.webp') }}" alt="Smart" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#" class="text-decoration-none no-underline">
                                <div class="product-category">
                                    <div class="product-title text-dark-grey">IF - Infovitríny</div>
                                    <div class="product-subtitle text-dark-grey">plakáty - dokumenty</div>
                                    <div class="product-image-container">
                                        <div class="product-image-bg">
                                            <div class="product-label text-dark-grey">infovitríny</div>
                                            <img src="{{ asset('assets/images/IF_group-map.webp') }}" alt="Infovitríny" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="/next" class="text-decoration-none no-underline">
                                <div class="p-3 text-start">
                                    <div class="product-title text-dark-grey">Next</div>
                                    <div class="product-subtitle mb-4 text-dark-grey">ostatní produkty</div>
                                    <div class="next-category">
                                        <a href="#" class="next-item text-dark-grey">- citylighty na sloupy</a>
                                        <a href="#" class="next-item text-dark-grey">- zastávkové označníky</a>
                                        <a href="#" class="next-item text-dark-grey">- orientační systémy</a>
                                        <a href="#" class="next-item text-dark-grey">- zastřešení</a>
                                        <a href="#" class="next-item text-dark-grey">- zakázková výroba</a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- View 2: Vaše preference (skryté) -->
                <div id="view-v2" class="submenu-view" style="display: none;">
                    <div class="category-header d-flex justify-content-center text-dark-grey">Rozdělení dle způsobu instalace</div>
                    <div class="grid-4">
                        <div>
                            <div class="product-category">
                                <div class="product-title text-dark-grey">Na noze</div>
                                <div class="product-subtitle text-dark-grey">
                                    <a class="link-product me-4" href="#!">Citylight</a>&nbsp;&nbsp;&nbsp;
                                    <a class="link-product ms-4" href="#!">Vitrína</a>
                                </div>
                                <div class="menu-image-container">
                                    <img src="{{ asset('assets/icons/na-noze.svg') }}" alt="Na noze" class="img-fluid" style="max-width:340px">
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="product-category">
                                <div class="product-title text-dark-grey">Na zeď</div>
                                <div class="product-subtitle text-dark-grey">
                                    <a class="link-product me-4" href="#!">Citylight</a>&nbsp;&nbsp;&nbsp;
                                    <a class="link-product ms-4" href="#!">Vitrína</a>
                                </div>
                                <div class="menu-image-container">
                                    <img src="{{ asset('assets/icons/na-zed.svg') }}" alt="Na zeď" class="img-fluid" style="max-width:290px">
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="product-category">
                                <div class="product-title text-dark-grey">Na sloup</div>
                                <div class="product-subtitle text-dark-grey">
                                    <a class="link-product me-4" href="#!">Citylight</a>
                                </div>
                                <div class="menu-image-container">
                                    <img src="{{ asset('assets/icons/na-sloup.svg') }}" alt="Na sloup" class="img-fluid" style="max-height:195px">
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="product-category text-start">
                                <div class="product-title text-dark-grey mb-3">Next</div>
                                <div class="product-subtitle text-dark-grey mb-4">Ostatní produkty</div>
                                <div class="next-category">
                                    <a href="#" class="next-item text-dark-grey">- Zastávkové označníky</a>
                                    <a href="#" class="next-item text-dark-grey">- Zastřešení</a>
                                    <a href="#" class="next-item text-dark-grey">- Zakázková výroba</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="submenu-switcher">
                    <div class="switcher-container gap-5 d-flex justify-content-end align-items-center me4-5">
                        <a href="mailto:obchod.project@mt3.cz" class="text-dark-grey fnt-size-125" style="text-decoration: none;">
                            Vaše preference <img src="{{ asset('assets/icons/obj_015.svg') }}" alt="" style="height: 1em; vertical-align: middle; margin-bottom:8px;">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
