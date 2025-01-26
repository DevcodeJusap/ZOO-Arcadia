// ...existing code...

// API route to add a new review
app.post('/api/reviews', async (req, res) => {
    const review = new Review({
        title: req.body.title,
        content: req.body.content,
        validated: req.body.validated
    });

    try {
        const newReview = await review.save();
        res.status(201).json(newReview);
    } catch (error) {
        res.status(400).json({ message: error.message });
    }
});

// ...existing code...