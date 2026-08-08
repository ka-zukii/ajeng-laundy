<x-landing-page-layout>

    @include('sections.hero', ['layanans' => $layanans])
    @include('sections.about')
    @include('sections.services')
    @include('sections.features')
    @include('sections.payment-feature')
    @include('sections.testimonials')
    @include('sections.faq')

</x-landing-page-layout>
