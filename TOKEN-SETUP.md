# GitHub Personal Access Token Setup

## Create New Token with Correct Scopes

1. **Go to:** https://github.com/settings/tokens/new

2. **Fill in the form:**

   **Token name (Note):**
   ```
   Klaro Theme CLI Access
   ```

   **Expiration:**
   ```
   90 days
   ```

   **Select scopes - CHECK THESE BOXES:**

   ✅ **repo** (Full control of private repositories)
      - Includes: repo:status, repo_deployment, public_repo, repo:invite, security_events

   ✅ **workflow** (Update GitHub Action workflows)

   ✅ **read:org** (Read org and team membership, read org projects)

   ✅ **user:email** (Access user email addresses (read-only))

3. **Scroll down and click:** "Generate token"

4. **COPY THE TOKEN** (starts with `ghp_`)
   - Save it somewhere safe
   - You'll use it in the next step

## Using the Token

After generating, run:

```bash
gh auth login
```

Choose:
- What account: **GitHub.com**
- Protocol: **HTTPS**
- Authenticate Git: **Yes**
- How to authenticate: **Paste an authentication token**
- Paste token: **[your new token here]**
