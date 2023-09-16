package familydomain

import (
	"encoding/json"
	"time"

	"github.com/arfan21/bookingtogo/constant"
)

type FamilyResponse struct {
	FLId       int       `json:"-"`
	FLName     string    `json:"nama"`
	FLRelation string    `json:"hubungan"`
	FLDOB      time.Time `json:"tanggal_lahir"`
	CstID      int       `json:"-"`
}

func (c *FamilyResponse) MarshalJSON() ([]byte, error) {
	type Alias FamilyResponse
	return json.Marshal(&struct {
		Alias
		FLDOB string `json:"tanggal_lahir"`
	}{
		Alias: (Alias)(*c),
		FLDOB: c.FLDOB.Format(constant.DOBFormat),
	})
}
