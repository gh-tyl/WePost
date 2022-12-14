# WePost

## Installation
```bash
git clone https://github.com/gh-tyl/WePost.git
cd WePost
cp .env.example .env
git checkout develop
git checkout -b feature/your_feature_branch
```

## Usage
Run your server and access to it.

## Rules
### CSS
- Use Bootstrap 5.

### Branches
- GitHub Flow
	- We use GitHub Flow. (https://guides.github.com/introduction/flow/)
- main: stable version
	- You can't push to this branch directly. You should create a pull request to merge develop branch to this branch.
- develop: development version
	- You can't push to this branch directly. You should create a pull request to merge your feature branch to this branch.
- feature/your_feature_branch: your feature branch
	- You can push to this branch directly.
	- Each feature branch should have only one feature. (Maybe it's difficult to do this. But if you can do this, it's better.)
	- Each feature branch should be created from develop branch.
	- Each feature branch should be merged to develop branch.
	- Each feature branch should be deleted after merged to develop branch.
	- Each feature branch should be named as feature/your_feature_branch.

### Pull Requests
- Before you create a pull request, you should pull the latest version of develop branch.
	- If you get a conflict, you should resolve it.
- You should create a pull request to merge your feature branch to develop branch.
- When you create a pull request, you should add reviewers.