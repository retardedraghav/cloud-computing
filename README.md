# 🎓 College Life Simulator (College Survival)

> Five days. Five decisions. One questionable life strategy.

College Life Simulator is an interactive, browser-based college-life simulation game built with **PHP, HTML, CSS and JavaScript**. Create a student, make a choice each day for five days, juggle your stats, and find out what kind of college student you turn into.

## Gameplay

1. **Create your character.** Enter a name, pick a course, and choose a personality.
2. **Survive five days.** Each day gives you a situation and a set of choices. Every choice changes your stats.
3. **See your ending.** The results page shows your final stats, your ending, and any achievements you unlocked.

### Personalities

| Personality | Academics | Attendance | Energy | Happiness | Stress |
|---|---|---|---|---|---|
| 💪 Hardworking | 70 | 80 | 60 | 55 | 40 |
| 😎 Chill | 55 | 65 | 75 | 75 | 20 |
| 🔥 Competitive | 65 | 75 | 70 | 55 | 45 |
| 💤 Procrastinator | 50 | 55 | 70 | 70 | 35 |

Every student starts with ₹2000 in money.

### Stats

- 📚 **Academics**
- 📅 **Attendance**
- ⚡ **Energy**
- 😊 **Happiness**
- 😰 **Stress**
- 💰 **Money**

Stats are kept between 0 and 100. Money can't go below 0.

## Project Structure

```
├── index.php       # Home / landing page
├── create.php      # Character creation (name, course, personality)
├── game.php        # Main game loop: Day 1–5 events and choices
├── results.php     # Final stats, ending and achievements
├── about.php       # About the project
├── functions.php   # Helpers: stat limits, result screens, day transitions
├── script.js       # Ask-Out dialogue interactions
└── style.css       # Styling
```

## Tech Stack

- **PHP:** game logic, stat changes, and state stored in PHP sessions
- **HTML:** page structure
- **CSS:** visual design
- **JavaScript:** Ask-Out dialogue

No database is needed. All game progress is stored in the PHP session.

## Running Locally

**Requirements:** PHP 7.4 or newer.

```bash
git clone https://github.com/retardedraghav/cloud-computing.git
cd cloud-computing
php -S localhost:8000
```

Then open <http://localhost:8000> in your browser.

You can also put the folder in the `htdocs` directory of XAMPP/WAMP and open `http://localhost/cloud-computing/`.

## Deploying to the Cloud

Because the app is plain PHP with no database, any PHP host can run it, for example:

- An **AWS EC2 / Azure VM / GCP Compute Engine** instance running Apache or Nginx with PHP
- **AWS Elastic Beanstalk** (PHP platform) or **Azure App Service** (PHP runtime)
- A Docker container based on the official `php:apache` image:

  ```dockerfile
  FROM php:8.2-apache
  COPY . /var/www/html/
  ```

## Future Scope

- MySQL database for saved progress
- More events and personalities
- Multiple players / leaderboard

