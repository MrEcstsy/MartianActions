# 🌌 MartianActions
A lightweight, modern **action item framework** for PocketMine-MP.  
MartianActions lets you create fully configurable items that run actions when used, perfect for crates, scrolls, reward bundles, kits, and custom gameplay mechanics.

Designed to be:
- **Clean & simple**
- **Highly configurable**
- **Mobile/console friendly**
- **More flexible than standard item-command plugins**
- **Powerful enough for advanced server systems**

---

## ✨ Features
- Run **multiple actions in order**
- Support for:
  - `run_commands` (console or player)
  - `message` (chat, title, or actionbar)
  - `play_effect` (Bedrock particle effects)
  - `give_items` (multiple custom items at once)
  - Clean NBT-based item identification
- Fully configurable via `items.yml`

This is **v1.0**, focusing on a clean foundation.  
More advanced features (conditionals, sound actions, random pools, cooldowns and more) are coming in future updates.

---

## 📝 Creating Action Items
All items are defined in `items.yml`.  
Each item has:
- A **unique identifier**
- Base item data (material, name, lore)
- Optional `remove-on-use`
- An action chain to execute

---
