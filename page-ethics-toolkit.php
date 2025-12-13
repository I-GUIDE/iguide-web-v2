<?php
/**
 * Template Name: Ethics Toolkit Page
 * Description: Page template for the I-GUIDE Data Ethics Toolkit
 */

get_header(); ?>

<div class="container-fluid tw-bg-white tw-min-h-screen">
    <div class="container tw-py-16">
        <div class="tw-text-center tw-mb-12">
            <h1 class="tw-text-4xl tw-font-bold tw-text-gray-800 tw-mb-4">
                I-GUIDE Data Ethics Toolkit
            </h1>
            <p class="tw-text-xl tw-text-gray-600 tw-max-w-3xl tw-mx-auto">
                A comprehensive toolkit for ethical geospatial data science including Research Product Management Plans,
                MEGAID ethics assessments, Data Cards, and Model Cards.
            </p>
        </div>

        <!-- Main Toolkit Interface -->
        <div class="tw-bg-white tw-rounded-lg tw-shadow-lg tw-p-8 tw-mb-8">
            <?php
            // Check if plugin is active
            if (class_exists('IGuideEthicsToolkit')) {
                echo do_shortcode('[idet_toolkit show_progress="true" theme="iguide"]');
            } else {
                // Fallback content if plugin is not active
                ?>
                <div class="tw-text-center tw-py-16">
                    <div class="tw-bg-yellow-50 tw-border tw-border-yellow-200 tw-rounded-lg tw-p-6 tw-mb-8">
                        <h3 class="tw-text-lg tw-font-semibold tw-text-yellow-800 tw-mb-2">
                            Plugin Not Active
                        </h3>
                        <p class="tw-text-yellow-700">
                            The I-GUIDE Data Ethics Toolkit plugin needs to be activated to use this page.
                            Please contact your administrator.
                        </p>
                    </div>

                    <!-- Static preview of what the toolkit offers -->
                    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-6 tw-mt-8">
                        <div class="tw-bg-blue-50 tw-border tw-border-blue-200 tw-rounded-lg tw-p-6">
                            <h4 class="tw-text-lg tw-font-semibold tw-text-blue-800 tw-mb-2">RPMP</h4>
                            <p class="tw-text-blue-700 tw-text-sm">
                                Research Product Management Plan for organizing and tracking your research outputs.
                            </p>
                        </div>

                        <div class="tw-bg-green-50 tw-border tw-border-green-200 tw-rounded-lg tw-p-6">
                            <h4 class="tw-text-lg tw-font-semibold tw-text-green-800 tw-mb-2">MEGAID</h4>
                            <p class="tw-text-green-700 tw-text-sm">
                                Managing Ethical Geospatial AI and Data Science tool for ethical compliance.
                            </p>
                        </div>

                        <div class="tw-bg-purple-50 tw-border tw-border-purple-200 tw-rounded-lg tw-p-6">
                            <h4 class="tw-text-lg tw-font-semibold tw-text-purple-800 tw-mb-2">Data Cards</h4>
                            <p class="tw-text-purple-700 tw-text-sm">
                                Document datasets with ethical considerations and usage guidelines.
                            </p>
                        </div>

                        <div class="tw-bg-red-50 tw-border tw-border-red-200 tw-rounded-lg tw-p-6">
                            <h4 class="tw-text-lg tw-font-semibold tw-text-red-800 tw-mb-2">Model Cards</h4>
                            <p class="tw-text-red-700 tw-text-sm">
                                Comprehensive model documentation including bias analysis and fairness assessment.
                            </p>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <!-- Information Section -->
        <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-8 tw-mb-8">
            <div class="tw-bg-gray-50 tw-rounded-lg tw-p-6">
                <h3 class="tw-text-xl tw-font-semibold tw-text-gray-800 tw-mb-4">
                    Why Use the Ethics Toolkit?
                </h3>
                <ul class="tw-space-y-3 tw-text-gray-700">
                    <li class="tw-flex tw-items-start">
                        <span class="tw-text-green-500 tw-mr-2">✓</span>
                        <span>Ensure compliance with GDPR, AI Act, and funding requirements</span>
                    </li>
                    <li class="tw-flex tw-items-start">
                        <span class="tw-text-green-500 tw-mr-2">✓</span>
                        <span>Standardize ethical documentation across all I-GUIDE projects</span>
                    </li>
                    <li class="tw-flex tw-items-start">
                        <span class="tw-text-green-500 tw-mr-2">✓</span>
                        <span>Generate professional reports for publications and funding agencies</span>
                    </li>
                    <li class="tw-flex tw-items-start">
                        <span class="tw-text-green-500 tw-mr-2">✓</span>
                        <span>Track project progress and maintain audit trails</span>
                    </li>
                </ul>
            </div>

            <div class="tw-bg-blue-50 tw-rounded-lg tw-p-6">
                <h3 class="tw-text-xl tw-font-semibold tw-text-blue-800 tw-mb-4">
                    Getting Started
                </h3>
                <ol class="tw-space-y-3 tw-text-blue-700">
                    <li class="tw-flex tw-items-start">
                        <span
                            class="tw-bg-blue-600 tw-text-white tw-rounded-full tw-w-6 tw-h-6 tw-flex tw-items-center tw-justify-center tw-text-sm tw-mr-3 tw-mt-0.5">1</span>
                        <span>Create a new ethics project above</span>
                    </li>
                    <li class="tw-flex tw-items-start">
                        <span
                            class="tw-bg-blue-600 tw-text-white tw-rounded-full tw-w-6 tw-h-6 tw-flex tw-items-center tw-justify-center tw-text-sm tw-mr-3 tw-mt-0.5">2</span>
                        <span>Complete the RPMP to plan your research outputs</span>
                    </li>
                    <li class="tw-flex tw-items-start">
                        <span
                            class="tw-bg-blue-600 tw-text-white tw-rounded-full tw-w-6 tw-h-6 tw-flex tw-items-center tw-justify-center tw-text-sm tw-mr-3 tw-mt-0.5">3</span>
                        <span>Use MEGAID to address ethical considerations</span>
                    </li>
                    <li class="tw-flex tw-items-start">
                        <span
                            class="tw-bg-blue-600 tw-text-white tw-rounded-full tw-w-6 tw-h-6 tw-flex tw-items-center tw-justify-center tw-text-sm tw-mr-3 tw-mt-0.5">4</span>
                        <span>Document datasets and models with cards</span>
                    </li>
                    <li class="tw-flex tw-items-start">
                        <span
                            class="tw-bg-blue-600 tw-text-white tw-rounded-full tw-w-6 tw-h-6 tw-flex tw-items-center tw-justify-center tw-text-sm tw-mr-3 tw-mt-0.5">5</span>
                        <span>Export comprehensive reports</span>
                    </li>
                </ol>
            </div>
        </div>

        <!-- Resources Section -->
        <div class="tw-bg-white tw-rounded-lg tw-shadow-lg tw-p-8">
            <h3 class="tw-text-2xl tw-font-semibold tw-text-gray-800 tw-mb-6 tw-text-center">
                Additional Resources
            </h3>

            <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-6">
                <div class="tw-text-center tw-p-4">
                    <div
                        class="tw-bg-blue-100 tw-rounded-full tw-w-16 tw-h-16 tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-4">
                        <i class="fa fa-file-pdf-o tw-text-2xl tw-text-blue-600"></i>
                    </div>
                    <h4 class="tw-font-semibold tw-text-gray-800 tw-mb-2">Primers & Guides</h4>
                    <p class="tw-text-gray-600 tw-text-sm">
                        Access comprehensive guides on GDPR, AI Act, and ethical considerations in geospatial science.
                    </p>
                </div>

                <div class="tw-text-center tw-p-4">
                    <div
                        class="tw-bg-green-100 tw-rounded-full tw-w-16 tw-h-16 tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-4">
                        <i class="fa fa-graduation-cap tw-text-2xl tw-text-green-600"></i>
                    </div>
                    <h4 class="tw-font-semibold tw-text-gray-800 tw-mb-2">Training Materials</h4>
                    <p class="tw-text-gray-600 tw-text-sm">
                        Educational resources and webinars to help you understand and implement ethical practices.
                    </p>
                </div>

                <div class="tw-text-center tw-p-4">
                    <div
                        class="tw-bg-purple-100 tw-rounded-full tw-w-16 tw-h-16 tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-4">
                        <i class="fa fa-users tw-text-2xl tw-text-purple-600"></i>
                    </div>
                    <h4 class="tw-font-semibold tw-text-gray-800 tw-mb-2">Community Support</h4>
                    <p class="tw-text-gray-600 tw-text-sm">
                        Connect with other I-GUIDE researchers and share best practices for ethical data science.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>