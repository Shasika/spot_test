<template>
    <div class="app">
        <!-- Jumbotron -->
        <div class="jumbotron text-center bg-dark text-white py-5 mb-5">
            <h1 class="display-4">Welcome to Spot Test</h1>
            <p class="lead">Contrary to popular is not simply random text</p>
        </div>

        <!-- About Section -->
        <div id="about" class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="text-uppercase mb-4">What is Lorem Ipsum?</h2>
                    <p class="mb-4">scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including version</p>
                    <p>Key Features:</p>
                    <ul class="list-unstyled mb-4">
                        <li><i class="fas fa-check mr-2"></i> Visualize data in interactive charts and graphs</li>
                        <li><i class="fas fa-check mr-2"></i> Analyze trends and patterns with advanced analytics</li>
                        <li><i class="fas fa-check mr-2"></i> Generate actionable insights with machine learning algorithms</li>
                        <li><i class="fas fa-check mr-2"></i> Collaborate seamlessly with your team</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <img src="https://via.placeholder.com/300" alt="Spot Test Image" class="img-fluid rounded-circle">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.app {
    font-family: 'Lato', sans-serif;
}

.jumbotron {
    background-color: #343A40;
}

.jumbotron h1,
.jumbotron p {
    color: #fff;
}

h2 {
    color: #303030;
    font-weight: 600;
}

.text-muted {
    color: #666;
}

.btn-primary {
    background-color: #007BFF;
    border-color: #007BFF;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.card-text {
    font-size: 16px;
}

.card-text,
.text-muted {
    margin-bottom: 0;
}
</style>
