<!-- Blog Create Form Partial -->
<section>
    <h2>Share Your Experience</h2>
    <form method="POST" action="/highstreetgym/controllers/content/blog_controller.php">
        <input type="hidden" name="action" value="create_post">
        
        <div class="mb-3">
            <label for="title" class="form-label">Post Title</label>
            <input 
                type="text" 
                class="form-control" 
                id="title" 
                name="title" 
                placeholder="Enter a title (5-200 characters)"
                required 
                minlength="5" 
                maxlength="200">
        </div>
        
        <div class="mb-3">
            <label for="message" class="form-label">Your Message</label>
            <textarea 
                class="form-control" 
                id="message" 
                name="message" 
                rows="5" 
                placeholder="Share your thoughts (10-2000 characters)"
                required 
                minlength="10" 
                maxlength="2000"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Post Message</button>
    </form>
</section>