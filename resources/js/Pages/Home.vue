<template>
    <span>
        <a :href="route('homepage')"><button>Homepage</button></a>
        <a :href="route('about')"><button>About</button></a>
        <a :href="route('contact')"><button>Contact</button></a>
    </span>

    <div>
        <h1>This is: {{ $page.props.title }}</h1>
    </div>
</template>
