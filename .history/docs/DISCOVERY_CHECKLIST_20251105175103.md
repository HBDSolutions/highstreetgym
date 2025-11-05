# Pre-Change Discovery Checklist

## Before Making ANY Changes:

### 1. **File Discovery**
- [ ] `file_search **/*{related_keyword}*`
- [ ] `list_dir` relevant directories
- [ ] Check for similar existing components

### 2. **Pattern Analysis**  
- [ ] `grep_search` for existing includes/requires
- [ ] `semantic_search` for similar functionality
- [ ] Review git history for context

### 3. **Architecture Review**
- [ ] Read existing controllers for patterns
- [ ] Check view structure and data flow
- [ ] Identify naming conventions

### 4. **Impact Assessment**
- [ ] What files reference existing components?
- [ ] What would break with changes?
- [ ] Can I extend vs. duplicate?

### 5. **Before Creating New Files**
- [ ] Does equivalent functionality exist?
- [ ] Can I refactor existing vs. create new?
- [ ] Am I following established patterns?

## Questions to Ask:
1. "What already exists that does this?"
2. "How is similar functionality implemented?"  
3. "What's the established pattern here?"
4. "Can I enhance existing vs. create new?"

## Tools to Use:
- `file_search` - Find existing files
- `grep_search` - Find usage patterns  
- `semantic_search` - Find similar functionality
- `list_dir` - Explore structure
- `read_file` - Understand existing code

## Golden Rule:
**DISCOVER → UNDERSTAND → ENHANCE → CREATE (only if necessary)**